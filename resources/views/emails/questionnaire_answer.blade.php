@if(request()->header('language') === 'ru')
    <h1>Уважаемый/ая, {{ $user->name ?? ' ' }}!</h1>
    <p>Во вложении Вы найдете результаты анкеты для вашего ребенка {{ $child->name }} {{ $child->age }} месяцев. Если у Вас есть вопросы Вы всегда можете нам написать на email: <a href="mailto:ozim.project@gmail.com">ozim.project@gmail.com</a> </p>
    <p>Продолжайте изучать материалы по развитию детей и быть активным в приложении Ozim Platform.</p>
    <p>Наш сайт <a href="https://ozimplatform.com">ozimplatform.com</a></p>
    <p>Наш инстаграм <a href="https://www.instagram.com/ozim.project/">ozim.project</a></p>
@else
    <h1>Құрметті ата-ана!
{{--        , {{ $user->name ?? ' ' }}--}}
    </h1>
    <p>Сізге жіберіліп отырған қосымшада балаңыз {{ $child->name }} {{ $child->age }} ай негізіндегі сауалнама нәтижелерін таба аласыз. Сұрақтарыңыз туындаған жағдайда бізбен мына электрондық пошта арқылы хабарласыңыз: <a href="mailto:ozim.project@gmail.com">ozim.project@gmail.com</a> </p>
    <p>Балалар дамуы жайлы материалдарын зерттеуді жалғастырып және Ozim Platform қосымшасында белсенді болуды ұмытпаңыз.
    </p>
    <p>Біздің сайт <a href="https://ozimplatform.com">ozimplatform.com</a></p>
    <p>Біздің Instagram <a href="https://www.instagram.com/ozim.project/">ozim.project</a></p>
@endif