@extends('layout.main')

@section('content')

	<div id="wufoo-s1ytd3o50g1rvqk">
Fill out my <a href="https://durisimoapps.wufoo.com/forms/s1ytd3o50g1rvqk">online form</a>.
</div>
<div id="wuf-adv" style="font-family:inherit;font-size: small;color:#a7a7a7;text-align:center;display:block;">There are tons of <a href="http://www.wufoo.com/features/">Wufoo features</a> to help make your forms awesome.</div>
<script type="text/javascript">var s1ytd3o50g1rvqk;(function(d, t) {
var s = d.createElement(t), options = {
'userName':'durisimoapps',
'formHash':'s1ytd3o50g1rvqk',
'autoResize':true,
'height':'806',
'async':true,
'host':'wufoo.com',
'header':'show',
'ssl':true};
s.src = ('https:' == d.location.protocol ? 'https://' : 'http://') + 'www.wufoo.com/scripts/embed/form.js';
s.onload = s.onreadystatechange = function() {
var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;
try { s1ytd3o50g1rvqk = new WufooForm();s1ytd3o50g1rvqk.initialize(options);s1ytd3o50g1rvqk.display(); } catch (e) {}};
var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);
})(document, 'script');</script>
@endsection