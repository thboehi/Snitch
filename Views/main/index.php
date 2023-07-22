<?php
$title = "Accueil";
$description = "Signalez, protégez, jouez. La plateforme essentielle pour les administrateurs de serveurs Minecraft. Pour une communauté francophone Minecraft plus sûre et agréable.";

?>
<div class="hero">
    <video autoplay loop muted plays-inline class="hero-video">
        <source src="/assets/videos/bg.webm" type="video/webm">
    </video>
    <!-- <a href="https://youtu.be/FqnAV6tkwzA" target=”_blank” id="chill-button"> CHILL</a> -->
    <div class="hero-text">
        <p class="hero-title">SNITCH</p>
        <p class="hero-description">Signalez, protégez, jouez. La plateforme essentielle pour les administrateurs de serveurs.</p>
        <p class="hero-description">Vers une communauté francophone Minecraft plus sûre et agréable.</p>
    </div>
    <div class="hero-buttons">
        <?php if (!isset($_SESSION["user"]) && !isset($_SESSION["alreadyLogged"])): ?>
            <a class="hero-button" href="/users/register" >Inscription</a>
        <?php elseif (isset($_SESSION["alreadyLogged"]) && !isset($_SESSION["user"])): ?>
            <a class="hero-button" href="/users/login" >Connexion</a>
        <?php else: ?>
            <a class="hero-button" href="/posts" >Liste</a>
        <?php endif; ?>
        <a class="hero-button" href="/posts/add">Dénoncer</a>
    </div>
</div>
<div class="index-main-container">
    <div class="index-rich-text-container" data-tilt data-tilt-max="5" data-tilt-glare data-tilt-max-glare="0.4">
        <div class="index-rtc-left">
            <h3>À Propos</h3>
            <p>Snitch est un outils pour administrateur et modérateurs de serveurs minecraft permettant de signaler des joueurs aux autres membres du site.</p>
            <p>Notre base de données est accessible pour tous les membres du site et <strong>c'est gratuit</strong> !</p>
        </div>
        <div class="index-rtc-right">
            <img src="/assets/images/minecraft.png">
        </div>
    </div>
    <div class="index-double-container">
        <div class="index-rich-text-container" data-tilt data-tilt-max="5" data-tilt-glare data-tilt-max-glare="0.4">
            <div class="index-rtc-left">
                <h3>Vous ?</h3>
                <p>Nous cherchons à travailler avec les administrateurs de serveurs. C'est à dire les fondateurs, les modérateurs, etc.</p>
                <p>Snitch est un outil d'administration, il ne s'adresse donc pas aux joueurs directement.</p>
                <p>Pour avoir accès à la partie "Signaler" du site web vous devrez contacter l'admin du site.</p>
            </div>
        </div>
        <div class="index-rich-text-container" data-tilt data-tilt-max="5" data-tilt-glare data-tilt-max-glare="0.4" style="cursor: pointer; display: flex; align-items: center; justify-content: center" onclick="window.location.href='/users/register'">
            <div class="index-rtc-left animate-on-scroll">
                <h3 style="text-align: center">Rejoins les </h3>
                <h3 id="numberUsersDisplay" style="font-size: 6rem; text-align: center; margin-top: 10px" >0</h3>
                <h3 style="text-align: center">membres inscrits sur Snitch !</h3>
            </div>
        </div>


    </div>
</div>

<script>
    function easeInOutCubic(t) {
        return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
    }

    function animateNumber(startValue, endValue, duration) {
        let startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = timestamp - startTime;
            const percentage = Math.min(progress / duration, 1);
            const easedProgress = easeInOutCubic(percentage);

            const currentValue = Math.floor(startValue + easedProgress * (endValue - startValue));

            $('#numberUsersDisplay').text(currentValue);

            if (percentage < 1) {
                requestAnimationFrame(step);
            }
        }

        requestAnimationFrame(step);
    }

    function startAnimationOnScroll() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.5 // Détecte lorsque l'élément est à moitié visible
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const endValue = <?= $data["numberUsers"]->total ?> + 24; // Récupérez la valeur depuis le contenu de l'élément
                    animateNumber(0, endValue, 2500); // 5000 ms (5 secondes) pour l'animation
                    observer.unobserve(element); // Une fois l'animation lancée, arrêtez d'observer cet élément
                }
            });
        }, observerOptions);

        elements.forEach(element => {
            observer.observe(element);
        });
    }

    // Lancez la fonction pour démarrer l'animation lorsqu'un élément est visible à l'écran
    $(document).ready(function() {
        startAnimationOnScroll();
    });
</script>