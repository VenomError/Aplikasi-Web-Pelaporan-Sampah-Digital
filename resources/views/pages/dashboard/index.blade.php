<div class=""></div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        navigator.geolocation.getCurrentPosition(console.log, console.error, {
            enableHighAccuracy: true
        });

    })
</script>
