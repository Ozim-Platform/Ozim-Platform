@extends('layouts.main')
@section('title', '- Поставщики услуг')

@section('content')

    <div class="col-12">
        @include('partials.messages')
        <div class="box">
            <form action="{{ route($namespace_store) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="box-header with-border">
                    <div class="mr-auto">
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route($namespace_store) }}"><i class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Поставщики услуг</li>
                                    <li class="breadcrumb-item active" aria-current="page">Добавление</li>
                                </ol>
                            </nav>
                            <a type="button" href="{{ route($namespace_index) }}" class="btn btn-info mb-5">Назад</a>
                            <button type="submit" class="btn btn-success mb-5">Сохранить и выйти</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Тема</label>
                        <div class="col-md-10">
                            <input  class="form-control" type="text" name="title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Платная</label>
                        <div class="col-md-10">
                            <input id="basic_checkbox_1" type="checkbox" @if(old('is_paid')) checked @endif name="is_paid">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Телефон</label>
                        <div class="col-md-10">
                            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') ?? 7 }}" required  placeholder="Телефон" data-mask="+0-000-000-00-00" data-mask-selectonfocus="false" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Почта</label>
                        <div class="col-md-10">
                            <input  class="form-control" type="text" name="email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Ссылка</label>
                        <div class="col-md-10">
                            <input  class="form-control" type="text" name="link">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Название</label>
                        <div class="col-md-10">
                            <input  class="form-control" type="text" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Теги (для поиска)</label>
                        <div class="col-md-10">
                            <input  class="form-control" type="text" name="tags">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Язык</label>
                        <select name="language" class="selectpicker col-md-10" required>
                            <option value="">Выберите язык</option>
                            @foreach($languages as $language)
                                <option
                                        value="{{ $language->sys_name }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Категория</label>
                        <select name="category" class="selectpicker col-md-10" required>
                            <option value="0">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option
                                        value="{{ $category->sys_name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Описание</label>
                        <div class="col-md-10">
                            <textarea id="tiny" class="textarea" placeholder="Описание"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description">
                                                                {{--<hr class="solid" style="border-top: 1px solid #62beb8;">--}}
{{--<p style="">Текст</p>--}}
{{--<hr class="solid" style="border-top: 1px solid #62beb8;"><p style=""><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAAkJJREFUSEvFVU0snFEUvWKkRiqhRKhMEVIjYTELEqOIqNjpVre1ZdmxLEtjyZYtW3aCiL+RsPgWmpj4iZ8ppZWSENPFNO09L3Obz3hv5lmIu5n5vnnvnnvOufdO1l8OesLIenaAy99xWogdU/T6F8VubxRX38t88he8ove+CirO9abln5bB+vdTmtqPUjyR0Cbxejz0scZPLWXlRhAjAJJPRr+qi8HS19Tlq6Q3XDnihJnMx44ocn6mnvsbAhQoLtGCaAHuuOLQxrKq/JO/3lihFAEm4eZ2yuPP1NACzLPm0yzN24JCGgw0EQBnD/dp7fyUk+TQO5akp7Ja5RpxNmn3+op6Waou9sQKQC4J9am9KC18O753FwAfqmrIufxB49vO/2KsAPqW5tS5sdZORbt/ZZHifxL0pTGo3g9vRaiIuyfc3KbYDawuqvcTHd12DARALmgBXuRSONiuEqaed6NoPZCEwmCG9Z89OtBKhDkZ3Fghb7aHxts67RiIB58DjWqgEPDB+XmhvqPvoT8CAzjqbD3Og4mdbdXjps5wlykdh1npq2uwYyCdgZUwlDT2wc3kiyE2HCvENGzGSRYf3DKlgog8Jv1x3gggxtayByH2QhfilcyE7owRQK2LCK8L7n+dF6I9qke76tZEWgb4UbzArgnxynAvuzCvCOyqdIsuI4CazmRHwXCAIJAcxpo6J+OguQ9AKkkIEASSC6BJGslh9ZfpBsFF2+RWEkklAoJnSJWp8kcxMA2ZzXsriWwSmc78A7bIc8jgrej0AAAAAElFTkSuQmCC" style="width: 24px;" data-filename="Icon_location_outline.png">&nbsp;Текст</p><p style=""><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAXCAYAAADk3wSdAAAABHNCSVQICAgIfAhkiAAAAktJREFUOE+9VUFy2kAQnFkfnFvIC8IPLL8gEq6y4RTnBRbkASEvMH4BfCCgvCDkBEmVEbwg8gtCfoBvIVXZSc8KYRlLyFyyJ9XuTs9s9/SIac8K4++esfaamC71mhAlhvnmU3Ax3hfHZYfv42+XIvKl8FwoGp4122WxhaBhHNdY1j9xWEN596hxQMQrVBwC6ETBLEsQBa15EXAhaOd2EhLzKA02p1Fwnui3JjP2d4Kz16Di66jRdLTsrjLQHgKvcflu2Gh6+SAkdGdCshg1Wv7BoKhmhWpe5QPbs0nExFcHgzrVxf5wYBDFmuOPURCsOrfTLnjtp/tyMzxr9Z5dqV7MKipWX35Z88LTRAeBug6w6x4zfdgJvIN4YSbeQaDZ5TCe1I1lqCw1a2he1kZ58NLmL3z2Mzf/H+jGUW+Y2YNVH/UiCyViOBGyC1CxrOQU/Png72pjx8rH6oCBEQaj4OLzE05T+637j8DgeWGas4hadMnGrMRaD3t1VOurVTMgBRc27awjePPUGOQ6O6pTDJtB1XjTrgB4T92VxtEKwBgy5wlnXt5Moy5cElW+O3dh4z6NOdGKYetT7sym+N5vu6okTgvhWO/pSOSHAUFL4WOMuWLr7QNuz6Zj0PcW88DZF5w6x0BFeqm8QIDurpplgFohC/czPdCC71QL1/zpv+jvOFNUwSHCXG3JYtyA3i6WOlvx0QU+guvbfZF2psfWUdsBghxadRWPD+0kC+Gjbn7APLGpgh/RH9+iGmLx8Dwvn0RbTv9X6UtkXOSqf8lmIis347RTAAAAAElFTkSuQmCC" style="width: 21px;" data-filename="Icon_user_outline.png">&nbsp;&nbsp;<span style="font-size: 1rem;">Текст</span></p><p><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAXCAYAAADgKtSgAAAABHNCSVQICAgIfAhkiAAAAmRJREFUSEulVcF12kAQndmLj6GD2BUEV2Bk3rPhZFxBBCkguILgCowLCCgdkBPE74HkCqIOQgnOLb7s5I/EikUWEIgukp5W//+Z+TPDtLrC+KnOYh+YqCFES2aORsH1vft+zB1YRCvgGC81HwQkqfBJEAXBy1HgYRzXWF5/AviUhH6z4VCsrRPzFwX8HwLuzWd9YnpQIMvmPAquUn3uzachCMaOYHzZOj9UPfcWMwX7ICTfxpft0AfwCRDC3ajZGh5CoOCInCCSb78G15Pyz93FbIKU3VSR7yMqwC0LCtdOyj8UkQk9jput/j5A/3sBXhV2dzGNmPhjXo9q8l1k65yXlHXnsyEzfc4KeoTqLNUORBsHjjhzSqA6geoL5PoZhW4ckg53lsN42jDCcTl0j/QFjXR2TCNlHbpWSanzM0hPQforUyEUwYbdQ9Wv2n+tHgm+HzXbAwWCzweuU3EflGfNp/hHR6zc4GjNGkqioPW44ZYix14Bfc+7qFwE1pzcaYp8JzmM8qjIlOulM8bIa4JHdCshzwa+v0rz2fMHjcQXeYZIh1iq0zN/l2fcls6yPkEBnhMgz5ZTzJp3PsGbFK0E+V1bnkU6TTfAc4KnurE2qSJYkXeEpUPCabljNwjQG2/Aqwnktmo0VLnHmSBbONvs5UegZyxTv+yGLeD5qNbdsA28iEBspEXOzglNrBG4pb2s+k+taUXGutGg/PtOcOcibCoMMFI/5xdIyHAqItgFBs6y2L/UcQ5S1RBR3wvu8LJiEWlTvd8VrVpTmEKN7p/BfRJh7rCI7tmcCEoBmMBFQ7/wfwFeQml1RJM3EAAAAABJRU5ErkJggg==" style="width: 23px;" data-filename="Сгруппировать 3203.png">&nbsp;<span style="font-size: 1rem;">Текст</span></p><p><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAXCAYAAADgKtSgAAAABHNCSVQICAgIfAhkiAAAAmRJREFUSEulVcF12kAQndmLj6GD2BUEV2Bk3rPhZFxBBCkguILgCowLCCgdkBPE74HkCqIOQgnOLb7s5I/EikUWEIgukp5W//+Z+TPDtLrC+KnOYh+YqCFES2aORsH1vft+zB1YRCvgGC81HwQkqfBJEAXBy1HgYRzXWF5/AviUhH6z4VCsrRPzFwX8HwLuzWd9YnpQIMvmPAquUn3uzachCMaOYHzZOj9UPfcWMwX7ICTfxpft0AfwCRDC3ajZGh5CoOCInCCSb78G15Pyz93FbIKU3VSR7yMqwC0LCtdOyj8UkQk9jput/j5A/3sBXhV2dzGNmPhjXo9q8l1k65yXlHXnsyEzfc4KeoTqLNUORBsHjjhzSqA6geoL5PoZhW4ckg53lsN42jDCcTl0j/QFjXR2TCNlHbpWSanzM0hPQforUyEUwYbdQ9Wv2n+tHgm+HzXbAwWCzweuU3EflGfNp/hHR6zc4GjNGkqioPW44ZYix14Bfc+7qFwE1pzcaYp8JzmM8qjIlOulM8bIa4JHdCshzwa+v0rz2fMHjcQXeYZIh1iq0zN/l2fcls6yPkEBnhMgz5ZTzJp3PsGbFK0E+V1bnkU6TTfAc4KnurE2qSJYkXeEpUPCabljNwjQG2/Aqwnktmo0VLnHmSBbONvs5UegZyxTv+yGLeD5qNbdsA28iEBspEXOzglNrBG4pb2s+k+taUXGutGg/PtOcOcibCoMMFI/5xdIyHAqItgFBs6y2L/UcQ5S1RBR3wvu8LJiEWlTvd8VrVpTmEKN7p/BfRJh7rCI7tmcCEoBmMBFQ7/wfwFeQml1RJM3EAAAAABJRU5ErkJggg==" style="width: 23px;" data-filename="Сгруппировать 3203.png">&nbsp;<span style="font-size: 1rem;">Текст</span></p><p><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEEElEQVR4Xr2VS2yUVRTHv6kDzOBMaemLMvQhtrV1USgEodMGbLBUN+LCqI1GjdGFRLrQHSERFy4UN8YSU6OpCxB8hWAwEookGhk1YGtE+xhR+9aWgZZ2oGOZcfz9v3zfZGaYNt3oTe7c853zP/9zzr3n3jGM/3g4FuOPx+OyZzHj1jQcDofkJY9FA4jlm/HRyoHpqeDg7DVj9HrYkIPvdo9R7l1l3JW7urqx2DewWLQFA3Rfnlh19Nf+6SuROdNfadvgZDnP5TYO+ncsyKPybxkfBPsutF/sEXlH3grXE3X5RSa5+zbnG64s5yHJ0mHzgdn/zNlT8aPBvnPaUuZkMuEtASCPnxkd2gzoyGMV1e8fbLj3CHXIp/uF2rrOvRvqOpCD0mEbB9POd6hrdMhPxf8gFxDkVTtISgC25TDksnW+vMX/0q7S8u/e7f3pzblo1PCvWXu8Jjevl3kR+UvpsJ1qLimLgf1eTvLtCZkF7MsYgDIfxzBMVsfKvNkTAgX+Gm9jmd99R8WnttOzd9fuQY5ha7kRjT5c6vH+gI9ppoqULU9UQLcErvwd0b4eJ/PTlJl1enjwQaE35hd25rvc5j7ZA93Hks/9OfY0y34qacfXUFOoCvzNdk4E6J++Ws93b3NJ+VcWSRzdU5I35ReeYFmWHKCtdlOrvsFsFQ/3Yy++JoStTkATAUbCs9fRfk5vi8y8UGRzJ2K4ce26L1hDJLWN6U4KFAOzXN/KGF/TBFcCkuhftVqS4830jJOzX4r8XlOLknRkvAcQKAWznZLGjaUQp2OctqLE41VpQVpuN10xiH7+wPnAGLrYa/Xbyzhk1V/DLGTmDbOlr5wPdOA3f2CLP0c86Ax0hrjskajAUlYNTF1torIIgJU8A32sPnR70F1mfs38BN07I7Mz91iYAGtA2wHO5M0YoDpn9VkZuZE6SCf4MLqT0nWHJnelHe4D6Mpko8N+A9uA/bOuERWOrqBIy7f6SVRAp+y0+vjJrpGh53FwNRT7Dgv0Y2hyeygyt94uG3knumZ91xUUNYL9EJ8i6x7xThXqgP0pAfTRWlWjW2scu9S/j/3cvNLpvKZnAVX2iT8uvQ5RFXMrsg+dG9vPYCrAPoLPRosj5UKmdBGlvXXfOrPyNRzW22zXizwRz/GK6snYwaXaxi1dj3y/dNgmyHxAB8tYLl+y9+o87GozvuPWiypMlIP+pdSTvaEnNGG4nM4L/DHcjMSi9Xquh8MzJ7loLeCWiby1snoKWY3w0KIBZOS6B3n8KrWvGgv+4fD+sLVhMg8Bc0FebJNrzViB9V+cozNkSzoJVjo0O2OM8ZepSD6Px+C1VbeMQ5wLbgWzDfJDyeQLBkgHEfBRdBXMM5atifV3CD9Kx/7v3/8CwvTVqxyiE5YAAAAASUVORK5CYII=" style="width: 24px;" data-filename="Icon_language_outline-removebg-preview.png">&nbsp;<span style="font-size: 1rem;">Текст</span><br></p><p><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAPCAYAAAALWoRrAAAABHNCSVQICAgIfAhkiAAAAWRJREFUOE+9lMFRwlAQhvfnwlGsQDrQDiQyo3BSKzBgAWIFhAqMDYR0IJ6CB4h2gB2kBDxyeb/7EhIRGSfBGd8hk8zb/d6/+/4NRFd/FnkEbiDStN9VF0WWoExMrX4fOs4SFijAsCpoZ7yCg3bn2kIThR4VQYAXOBejModorqsVPmiFjTzeoH6I/nyq6kX08aybl+v3BVHrhc75YhfcjaMmiLHGt9b770I2rDgDOgU0OOvgNn65omEokIM0mOJrn0a2Tzm8P5sOCBmm6igfGuQH7a7Xm0evEJz+gNpEN44b4CrcUJ0Q7OlWsqmOwjeFu6HTTWzer9BcUaba+Hm/0xsu1ImnF+JvtqYUtFBtVh4gd1k3vqvbC5on6cW0agYn2+r+BC1jr9Lll4HlMf8CtQY/tp5Uw0+qqPuaQuowqL91Wb9nhief9oJtJZHyOG53Bmo9EQs2pKumKWa46iH6lwp1slK1n0nW18Re0R3ZAAAAAElFTkSuQmCC" style="width: 21px;" data-filename="Сгруппировать 3204.png">&nbsp;&nbsp;<span style="font-size: 1rem;">Текст</span><br></p>--}}
{{--<hr class="solid" style="border-top: 1px solid #62beb8;">--}}

                            </textarea>


                        </div>
                    </div>
                    <div class="form-group row">
                        <h5 class="col-form-label col-md-2">Фото <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <h5 class="col-form-label col-md-2">Обложка <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="preview" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Автор</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="author">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Должность автора</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="author_position">
                        </div>
                    </div>
                    <div class="form-group row">
                        <h5 class="col-form-label col-md-2">Фото автора <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="author_photo" class="form-control">
                        </div>
                    </div>
                </div>
            </form>

        </div>

        <!-- /.box -->
    </div>


@endsection
@push('footer_scripts')
    <script type="text/javascript" src="/js/jquery.mask.js"></script>
@endpush