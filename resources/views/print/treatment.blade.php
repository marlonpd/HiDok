<div text-align="center" width="100%">
    <div style="text-align:center;margin:auto;">
        <img style="height:50px;text-align:center;margin:auto;" src="/images/header_logo.png">
    </div>
    <p style="text-align:center;">
        <b>{{ $clinic->name }}</b><br>
        <small>{{ $clinic->address }}</small>
    </p>
</div>

<hr style="height:1px;border:none;color:#333;background-color:#333;">
<div>
<div style="float:left">
    Patient Name : <u>{{ $patient->fullname() }}</u> 
    <br>
    Address : <u> {{ $patient->address }}</u> 
</div>

<div style="float:right">
    Age:______ &nbsp; Sex: <u>{{ $patient->gender }}</u> 
    <br>
    Date:<u>{{ date('Y-m-d') }}</u>
</div>
<div style="clear:both;"></div>
</div>
<hr style="height:1px;border:none;color:#333;background-color:#333;">
<br>
<br>
<br>

<img style="height:50px;" src="/images/rx.png">


@foreach ($itr as $key=>$treatment)
    <p style="margin-bottom:0;padding-bottom:0;">{{ ($key+1) }}.  {{ $treatment->value }}</p>
    <p style="margin-top:0;padding-top:0;">&nbsp;&nbsp;&nbsp;&nbsp;Sig : {{ $treatment->sig }}</p>
    <p></p>
@endforeach

<br><br><br><br>

<div style="float: right;">
    __________________ <br>
    {{ Auth::user()->fullname() }} <br>
    License no : ________<br>
    PTR No. : _________
    <br>
</div>

<br><br><br>

<INPUT TYPE="button" onClick="window.print()" value="PRINT">