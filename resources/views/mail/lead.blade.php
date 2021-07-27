<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<p>Dear {{$inputs['lead']->name}},</p>

<p>Greetings.</p>

<p>
    I am Abhishek Soni. We are discussing your {{$inputs['lead']->requirements}} requirements.
</p>

<p>Initial requirements you mentioned: {{$inputs['lead']->initial_requirements}}</p>

<p>
    Introducing {{$inputs['partner']->name}}. {{$inputs['partner']->name}} is based
    at {{isset($inputs['partner']->city->description)? $inputs['partner']->city->description.', ':''}}{{$inputs['partner']->country->description}}
    and can surely help you in your requirements.
</p>

<p>Dear {{$inputs['partner']->name}},</p>

<p>
    Please help to introduce yourself and initiate the discussion further from here.
    If possible please share your portfolio/cv/company profile.
</p>


<p>Thanks,<br />Abhishek</p>

</body>
</html>
