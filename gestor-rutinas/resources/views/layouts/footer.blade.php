<footer class="text-white py-5 mt-auto" style="background: linear-gradient(135deg, #000000 0%, #7C97A1 100%);">
    <div class="container">
        <div class="row justify-content-center text-center">
            <!-- Logo y descripción centrado -->
            <div class="col-lg-6 mb-4">
                <div class="mb-3">
                    <i class="fas fa-dumbbell fs-2 mb-2" style="color: #76B4AA;"></i>
                </div>
                <h4 class="fw-bold mb-3" style="color: #FFFFFF;">Rhiannon</h4>
                <p class="mb-4" style="color: #FFFFFF; opacity: 0.8; font-size: 1.1rem;">
                    Tu compañero perfecto para alcanzar tus objetivos fitness
                </p>

                <!-- Botón volver arriba -->
                <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="btn px-4 py-2 me-3 mb-3"
                    style="background-color: #76B4AA; color: #FFFFFF; border: none; transition: all 0.3s ease;">
                    <i class="fas fa-arrow-up me-2"></i>Volver arriba
                </button>
            </div>
        </div>

        <!-- Línea divisoria sutil -->
        <div class="row">
            <div class="col">
                <hr style="border-color: rgba(118, 180, 170, 0.3); margin: 2rem 0 1.5rem 0;">
                <p class="text-center mb-0" style="color: #FFFFFF; opacity: 0.7; font-size: 0.9rem;">
                    &copy; {{ date('Y') }} Rhiannon.
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Hover effects para los botones del footer */
    footer .btn:hover {
        background-color: #5a9088 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(118, 180, 170, 0.3);
    }
</style>