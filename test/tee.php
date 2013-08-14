<span class="output" id="payment"></span>
<form>
<input type="text" name="payment" id="payment" onchange="calculate()" />
</form>
<script>

function calculate() {
var payment = document.getElementById("payment").value;

document.write(payment);
}
</script>