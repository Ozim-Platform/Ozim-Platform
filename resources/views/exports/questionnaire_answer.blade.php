<html>

<head>
    <style>
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
    </style>
</head>

<body>
<div style="
height:600px;
padding:20px;
">
    <div style="
    height:550px;
    padding:20px;
     ">
        <div style="text-align:center;">
            <span style="font-size:40px; font-weight:bold; color: #778083;">Результаты анкеты {{ $child->name }}</span>
            <br><br>
            <span style="font-size:25px; color: #777F83">Для возраста {{ $answer->age }} месяцев</span>
            <br><br>
        </div>
        <div class="container">
            @foreach($answer->answers as $theme => $item)
                @if($loop->index !== 5)

                    <span style="font-size:25px; color: #6CBBD9;">{{ $theme }}</span> <br/>

                    <span style="
                            width:25px;
                            height:25px;
                            border-radius:50%;
                            background: #fff;
                            position:absolute;
                            margin-left: {{ $item['total']/60*100-4 }}%;
                            ">
                        &nbsp;
                    </span>
                    <div style=" height: 15px;
                        width:100%; display:table;">
                        <span style="display:table-cell; border-bottom-left-radius: 10px; border-top-left-radius: 10px; background-color: #6CBBD9; width: {{ $answer->questionnaire->questions[$theme]['ranges']['#6CBBD9']/60*100 }}%">&nbsp;</span>
                        <span style="display:table-cell; background-color: #F2C477; width: {{ $answer->questionnaire->questions[$theme]['ranges']['#F2C477']/60*100 }}%">&nbsp;</span>
                        <span style="display:table-cell; border-bottom-right-radius: 10px; border-top-right-radius: 10px; background-color: #79BCB7; width: {{ $answer->questionnaire->questions[$theme]['ranges']['#79BCB7']/60*100 }}%">&nbsp;</span>
                    </div>
                    <br>
                @endif
            @endforeach
        </div>
        <br>
        <div class="container">
            <span style="color: #7F878B;">
                Если общий балл ребенка находится в <span style="color: #6CBBD9;">зеленом поле,</span> он выше порогового значения, и развитие ребенка идет по графику.
            </span><br><br>
            <span style="color: #7F878B;">
                Если общий балл ребенка находится в <span style="color: #F2C477;">оранжевом поле,</span> он близок к пороговому значению. Обеспечьте учебную деятельность и контролируйте.
            </span><br><br>
            <span style="color: #7F878B;">
                Если общий балл ребенка находится в <span style="color: #79BCB7;">голубом поле,</span> он ниже порогового значения. Может потребоваться дополнительная оценка профессионала.
            </span>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div style="text-align:center;">
        @foreach($answer->answers as $theme => $item)
            <span style="font-size:25px; color: #F1BC62;">{{ $theme }}</span> <br/>
            @foreach($item['answers'] as $index => $i)
                <p style="color: #7F878B;">
                    {{ $loop->iteration }}. {{ $answer->questionnaire->questions[$theme]['questions'][$index] }}
                </p>
                @if($loop->parent->index !== 5)
                    <input type="radio" id="{{ \Str::slug($theme) . 10 }}" value="10" @if($i === 10) checked @endif>
                    <label style="color: #7F878B;" for="{{ \Str::slug($theme) . 10 }}">ДА</label>
                    <input type="radio" id="{{ \Str::slug($theme) . 5 }}" value="5" @if($i === 5) checked @endif>
                    <label style="color: #7F878B;" for="{{ \Str::slug($theme) . 5 }}">ИНОГДА</label>
                    <input type="radio" id="{{ \Str::slug($theme) . 1 }}" value="0" @if($i === 0) checked @endif>
                    <label style="color: #7F878B;" for="{{ \Str::slug($theme) . 1 }}">НЕТ</label> <br/><br/>
                @else
                    <input type="radio" id="{{ \Str::slug($theme) . true }}" value="true" @if($i['value'] === true) checked @endif>
                    <label style="color: #7F878B;" for="{{ \Str::slug($theme) . true }}">ДА</label>
                    <input type="radio" id="{{ \Str::slug($theme) . false }}" value="false" @if($i['value'] === false) checked @endif>
                    <label style="color: #7F878B;" for="{{ \Str::slug($theme) . false }}">НЕТ</label> <br/> <br>
                    <div style="background: #F4F4F4; border-radius: 15px; border: 1px solid #CECECE; padding: 10px; display: inline-block;">
                        <span style="color: #7F878B;">{{ $i['comment'] }}</span>
                    </div>
                @endif
            @endforeach
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        @endforeach
        </div>
    </div>
</div>
</body>
</html>
