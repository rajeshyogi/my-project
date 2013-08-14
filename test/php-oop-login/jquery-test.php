<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<a id="buttonsend" class="notsosmall pink button">
     <span>More Info</span>
     <span style="display:none">Less Info</span>
 </a>

<script>
   $('a#buttonsend').click(function() {
    $('span',this).toggle();
});
</script>

