<div class="clearfix">
    <div class="menu_header">
        <ul class="main-menu bottom">
            <?php showMenu($menu, $path)?>
        </ul>
    </div>
</div>
<div class="footer">
    &copy;&nbsp;<nobr><?=date('Y')?></nobr> Project.
</div>
<script src="../js/jquery-1.9.0.min.js"></script>
<script src="../js/jquery.accordion.js"></script>
<script src="../js/jquery.cookie.js"></script>
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" project-folders-v-active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " project-folders-v-active";
    }
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>