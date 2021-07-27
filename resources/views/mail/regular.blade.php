
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<p >Dear {{$inputs['partner']->name}},</p>

<p >Greetings.</p>

<p >
    I am Abhishek Soni from India. I am owning Malhar Infoway. I am in a collaboration business
</p>

@if(is_null($inputs['lead']->world_wide))
    <p>My client is looking for {{isset($inputs['lead']->city->description)? $inputs['lead']->city->description.', ':''}}{{$inputs['lead']->country->description}} based {{$inputs['lead']->requirements}}.
        I will connect you with them. Are you open to collaboration?</p>
@endif
@if($inputs['lead']->world_wide == 1)
    <p>My client is looking for {{$inputs['lead']->requirements}}.
        I will connect you with them. Are you open to collaboration?</p>
@endif
<p>Initial requirements: {{$inputs['lead']->initial_requirements}}</p>

<p>I am following the collaboration-based business model. Means:</p>

<p>1. I will share the client contact details with you and introduce you as a collaborator.</p>

<p>2. You will discuss everything and responsible to execute the project. You will be invoiced to the client under your brand name.</p>

<p>3. You will pay me {{$inputs['partner']->percentage}}% (Open to negotiate and love to hear your offer) on each invoice (based on invoice amount and not on the profit) until the finish of the project, only if you win the project and after getting paid by client.</p>

<p>4. You will only pay me if and when you get paid by the client. No other charges.</p>

<p>5. This is not just for one project. It is for any upcoming inquiries by me.</p>

<p>Please let me know if you agree so that I can connect you with my client.</p>

<p><b>NOTE:</b></p>
<p>1.If you want to go ahead, please reply this email <b>“YES”</b> – do not change subject line
    <br />2.If you do not want this email please <a href="{{route('partners.unsubscribe', encrypt($inputs['partner']->id))}}">click here</a> </p>

<p>Thanks,<br />
    Abhishek <br />
    CEO<br />
    Malhar Infoway, India</p>
</p>

</body>
</html>
