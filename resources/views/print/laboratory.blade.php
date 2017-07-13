
<div text-align="center" width="100%">
    <div style="text-align:center;margin:auto;">
        <img style="height:50px;text-align:center;margin:auto;" src="/images/header_logo.png">
    </div>
    <p style="text-align:center;"><b>{{ $clinic->name }}</b><br>
    <small>{{ $clinic->address }}</small></p>
</div>

<hr style="height:1px;border:none;color:#333;background-color:#333;">
<div>
    <div style="float:left">
        Patient Name : <u>{{ $patient->firstname}} {{ $patient->lastname}}</u> 
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

<h3>Diagnostic requests: </h3>

@foreach ($itr as $laboratory)
    <span>{{ trim($laboratory->value) }}</span>,&nbsp;&nbsp;&nbsp;
@endforeach
<br><br><br>

<div style="float: right;">
    __________________ <br>
    {{  Auth::user()->fullname() }} <br>
    License no : ________<br>
    PTR No. : _________
    <br>
</div>

<br><br><br>

<INPUT TYPE="button" onClick="window.print()" value="PRINT">