<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Gm Llaves y Cerraduras - Servicios profesionales de cerrajería para hogares y empresas">
    <meta name="keywords" content="cerrajería, llaves, cerraduras, seguridad, apertura de puertas, productos de cerrajería">
    <title>@yield('title', 'GM Llaves y Cerraduras')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/ESTILOS.CSS') }}">
    
    @stack('styles')
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="{{ asset('imagenes/imagenes/img/logo12.png') }}" alt="GM Llaves y Cerraduras">
                <h1>GM Llaves y Cerraduras</h1>
            </div>
      
            <nav>
                <ul id="nav-menu">
                    <li><a href="{{ route('home') }}#servicios">Servicios</a></li>
                    <li><a href="{{ route('home') }}#productos">Productos</a></li>
                    <li><a href="{{ route('home') }}#sobre-nosotros">Nosotros</a></li>
                    <li><a href="{{ route('home') }}#testimonios">Testimonios</a></li>
                    <li><a href="{{ route('home') }}#contacto">Contacto</a></li>
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                        @else
                            <li><a href="{{ route('appointments.index') }}">Mis Citas</a></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; font: inherit;">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                        <li><a href="{{ route('register') }}">Registrarse</a></li>
                    @endauth
                    
                    <li><a href="{{ route('appointments.create') }}" class="btn-agendar">Agendar Cita</a></li>
                </ul>
            </nav>
      
            <div class="mobile-menu" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif

    @yield('content')

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Gm Llaves y Cerraduras</h3>
                    <p>Expertos en seguridad para hogares y empresas. Ofrecemos soluciones profesionales y confiables.</p>
                    <ul class="social-icons">
                        <li><a href="https://facebook.com/gmllavesycerraduras" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="https://instagram.com/gmllavesycerraduras" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="https://wa.me/573022387020" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Enlaces Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}#servicios">Servicios</a></li>
                        <li><a href="{{ route('home') }}#productos">Productos</a></li>
                        <li><a href="{{ route('home') }}#sobre-nosotros">Sobre Nosotros</a></li>
                        <li><a href="{{ route('home') }}#testimonios">Testimonios</a></li>
                        <li><a href="{{ route('home') }}#contacto">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Servicios</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}#servicios">Apertura de Puertas</a></li>
                        <li><a href="{{ route('home') }}#servicios">Cambio de Cerraduras</a></li>
                        <li><a href="{{ route('home') }}#servicios">Sistemas de Seguridad</a></li>
                        <li><a href="{{ route('home') }}#servicios">Copia de Llaves</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <ul class="contact-details">
                        <li><i class="fas fa-phone-alt"></i> +57 302 238 70 20</li>
                        <li><i class="fas fa-envelope"></i> gmllaves@gmail.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Servicio a domicilio</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Gm Llaves y Cerraduras. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <div class="scroll-top" id="scroll-top">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script>
        // Menú móvil
        const mobileMenu = document.getElementById('mobile-menu');
        const navMenu = document.getElementById('nav-menu');
        
        if (mobileMenu) {
            mobileMenu.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }
        
        // Botón scroll to top
        const scrollTop = document.getElementById('scroll-top');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        });
        
        if (scrollTop) {
            scrollTop.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Auto-cerrar alertas después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>