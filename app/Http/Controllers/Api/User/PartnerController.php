<?php


namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use App\Models\User;
use App\Models\UserCertificates;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

/**
 * класс предназначенный для работы с детьми авторизированным пользователем
 * Class UserController
 * @package App\Http\Controllers\Api\User
 */
class PartnerController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        $partners = Partner::query()->where(function ($q) use ($request){

            if ($request->has('id'))
                $q->where('id', (int)$request->id);

        })->paginate($request->limit ?? 10);

        return response()->json(['data' => PartnerResource::collection($partners), 'page' => $partners->currentPage(), 'pages' => $partners->lastPage()]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function change(Request $request)
    {
        $request->partner_id = (int)$request->partner_id;
        // инициализация валидатора
        if (!Partner::query()->where('id', $request->partner_id)->exists())
            return response()->json(['error' => 'partner_id | Недействительное значение'], 422);

        $user = User::query()->where('id', auth()->user()->id)->first();

        $partner = Partner::query()->where('id', $request->partner_id)->first();

        if ($user->points < $partner->price)
            return response()->json(['error' => 'У вас не хватит баллов!'], 422);

        if (UserCertificates::query()
            ->where('user_id', $user->id)
            ->where('partner_id', $partner->id)
            ->exists()
        )
            return response()->json(['error' => 'Вы уже обменивались с этим партнером!'], 422);

        if (!$user->email)
            return response()->json(['error' => 'У вас нет почты в профиле, укажите ее!'], 422);

        $user->points -= $partner->price;

        $filename = 'certs/'.Str::slug($partner->name) . '-' . now()->timestamp . '.pdf';

        $path = "storage/$filename";

        $outputFile = Storage::disk('public')->path($filename);

        // fill data
        $this->fillPDF(public_path('cert.pdf'), $outputFile, $partner);

        $cert = UserCertificates::query()->create([
            'user_id' => auth()->user()->id,
            'partner_id' => $partner->id,
            'file' => $path,
        ]);

        (new EmailService())->sendCert($user, $partner, public_path($path));

        // проверка на неуспешность создания
        if (!$cert || !$user->save())
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно поменялись'])->setStatusCode(200);
    }

    public function fillPDF($file, $outputFile, $partner) : string
    {
        $fpdi = new Fpdi;

        // запись
        $count = $fpdi->setSourceFile($file);
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $fpdi->AddFont('Time', '', 'times-new-roman.php');
            $fpdi->SetFont("Time", '', '15');
            $fpdi->SetTextColor(58, 125, 182);
            $fpdi->Text(25,153, iconv('utf-8', 'windows-1251', $partner->title));
            $fpdi->Text(25,179, iconv('utf-8', 'windows-1251', $partner->name));
            $fpdi->Text(225,179, now()->addMonths($partner->expires ?? 1)->format('d.m.Y'));
        }
        return $fpdi->Output($outputFile, 'F');
    }

}
