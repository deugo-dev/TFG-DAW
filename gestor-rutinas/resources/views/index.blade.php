@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<style>
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000000;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: transform 0.5s ease-out;
    }

    .preloader-logo img {
        width: 500px;
        opacity: 0;
        animation: fadeInLogo 0.5s ease forwards;
    }

    @keyframes fadeInLogo {
        to {
            opacity: 1;
        }
    }

    #preloader.hide {
        transform: translateY(-100%);
        pointer-events: none;
    }

    .hero {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #FFFFFF;
    }

    .hero-left {
        background: #000000;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4rem;
        position: relative;
    }

    .hero-title {
        font-size: clamp(2rem, 6vw, 4rem);
        font-weight: 800;
        margin-bottom: 1rem;
        color: #ffffff;
        text-align: left;
        opacity: 0;
        animation: slideUp 0.8s ease-out 0.3s forwards;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        color: #ffffff;
        text-align: left;
        opacity: 0;
        animation: slideUp 0.8s ease-out 0.5s forwards;
    }

    .hero-right {
        background: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: right;
        padding: 4rem;
        position: relative;
        overflow: hidden;
    }

    .background-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.70;
        z-index: 1;
    }

    .cta-button {
        background: #76B4AA;
        color: #FFFFFF;
        padding: 1rem 2rem;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(15px);
        animation: slideUp 0.8s ease-out 0.9s forwards;
        align-self: flex-start;
    }

    .cta-button:hover {
        background: #7C97A1;
        transform: translateY(-2px);
        color: #FFFFFF;
        text-decoration: none;
    }

    .hero-overlay-text {
        position: relative;
        z-index: 1;
        text-align: right;
        color: #000000;
        animation: fadeIn 1s ease-out forwards;
    }

    .hero-call {
        font-size: clamp(2rem, 6vw, 4rem);
        font-weight: 800;
        margin-bottom: 1rem;
        opacity: 0;
        animation: slideUp 0.8s ease-out 0.3s forwards;
    }

    .hero-call-sub {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0;
        animation: slideUp 0.8s ease-out 0.5s forwards;
    }

    .cta-secondary {
        background: transparent;
        border: 2px solid #000000;
        padding: 0.8rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        color: #000000;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
        opacity: 0;
        animation: slideUp 0.8s ease-out 0.7s forwards;
    }

    .cta-secondary:hover {
        background: #000000;
        color: #FFFFFF;
    }

    .accent-line {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #76B4AA, #7C97A1);
    }

    .features {
        padding: 5rem 2rem;
        background: #000000;
        color: #FFFFFF;
    }

    .features-container {
        max-width: 1200px;
        margin: 0 auto;
        text-align: center;
    }

    .features-title {
        font-size: clamp(2rem, 4vw, 3rem);
        margin-bottom: 3rem;
        font-weight: 700;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 3rem;
        margin-top: 4rem;
    }

    .feature-card {
        background: #FFFFFF;
        color: #000000;
        padding: 2.5rem 2rem;
        border-radius: 10px;
        transition: transform 0.3s ease;
        border-left: 4px solid #76B4AA;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .feature-card:nth-child(2) {
        border-left-color: #7C97A1;
    }

    .feature-card:nth-child(3) {
        border-left-color: #653F41;
    }

    .feature-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .feature-description {
        line-height: 1.6;
        color: #666;
    }

    .exercise-types {
        padding: 5rem 2rem;
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
        url('{{ asset("images/gym-background.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #FFFFFF;
    }

    .exercise-types-container {
        max-width: 1200px;
        margin: 0 auto;
        text-align: center;
    }

    .exercise-types-title {
        font-size: clamp(2rem, 4vw, 3rem);
        margin-bottom: 1rem;
        font-weight: 700;
        color: #FFFFFF;
    }

    .exercise-types-subtitle {
        font-size: 1.2rem;
        color: #FFFFFF;
        margin-bottom: 4rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        opacity: 0.9;
    }

    .exercise-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .exercise-item {
        background: rgba(255, 255, 255, 0.95);
        color: #000000;
        padding: 2rem 1.5rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .exercise-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        background: rgba(255, 255, 255, 1);
    }

    .exercise-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-transform: capitalize;
        color: #000000;
    }

    .exercise-description {
        font-size: 1rem;
        color: #333;
        line-height: 1.6;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .hero {
            grid-template-columns: 1fr;
        }

        .hero-left,
        .hero-right {
            padding: 3rem 2rem;
            text-align: center;
        }

        .exercise-types {
            background-attachment: scroll;
        }
    }
</style>

<div id="preloader">
    <div class="preloader-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
</div>

<section class="hero">
    <div class="hero-left">
        <h2 class="hero-title">Tu entrenamiento, a tu manera</h2>
        <p class="hero-subtitle">Tu plataforma personalizada para crear y gestionar rutinas de entrenamiento</p>

        @auth
        <a href="{{ route('dashboard') }}" class="cta-button">Ir a mi panel</a>
        @else
        <a href="{{ route('login') }}" class="cta-button">Iniciar sesión</a>
        @endauth

        <div class="accent-line"></div>
    </div>

    <div class="hero-right">
        <video class="background-video" autoplay muted loop>
            <source src="{{ asset('videos/workout-' . rand(1,3) . '.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay-text">
            <h2 class="hero-call">Únete a nosotros</h2>
            <p class="hero-call-sub">De forma gratuita y empieza hoy</p>
            @guest
            <a href="{{ route('register') }}" class="cta-button cta-secondary">Crear cuenta</a>
            @endguest
        </div>
    </div>
</section>

<section class="features">
    <div class="features-container">
        <h2 class="features-title">Transforma tu entrenamiento</h2>

        <div class="features-grid">
            <div class="feature-card">
                <h3 class="feature-title">Rutinas Personalizadas</h3>
                <p class="feature-description">Crea rutinas adaptadas a tus objetivos, nivel de fitness y necesidades.</p>
            </div>

        </div>
    </div>
</section>

<section class="exercise-types">
    <div class="exercise-types-container">
        <h2 class="exercise-types-title">Tipos de Ejercicios</h2>
        <p class="exercise-types-subtitle">Configura y personaliza diferentes modalidades de entrenamiento según tus objetivos y preferencias</p>

        <div class="exercise-grid">
            <div class="exercise-item">
                <h3 class="exercise-name">Fuerza</h3>
                <p class="exercise-description">Desarrolla músculo y potencia con entrenamientos de resistencia y pesas</p>
            </div>

            <div class="exercise-item">
                <h3 class="exercise-name">Estiramiento</h3>
                <p class="exercise-description">Mejora tu flexibilidad y reduce tensiones musculares</p>
            </div>

            <div class="exercise-item">
                <h3 class="exercise-name">Cardio</h3>
                <p class="exercise-description">Fortalece tu sistema cardiovascular y quema calorías</p>
            </div>

            <div class="exercise-item">
                <h3 class="exercise-name">Flexibilidad</h3>
                <p class="exercise-description">Aumenta tu rango de movimiento y previene lesiones</p>
            </div>

            <div class="exercise-item">
                <h3 class="exercise-name">Movilidad</h3>
                <p class="exercise-description">Optimiza el movimiento funcional de tus articulaciones</p>
            </div>

            <div class="exercise-item">
                <h3 class="exercise-name">Core</h3>
                <p class="exercise-description">Fortalece tu centro y mejora la estabilidad corporal</p>
            </div>

            <div class="exercise-item">
                <h3 class="exercise-name">Calistenia</h3>
                <p class="exercise-description">Entrena con el peso de tu propio cuerpo</p>
            </div>
        </div>
    </div>
</section>

<script>
    window.addEventListener('load', () => {
        const preloader = document.getElementById('preloader');
        setTimeout(() => {
            preloader.classList.add('hide');
        }, 1500);
    });
</script>

@endsection