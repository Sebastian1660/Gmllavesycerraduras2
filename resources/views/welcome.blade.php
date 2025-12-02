@extends('layouts.app')

@section('title', 'GM Llaves y Cerraduras - Inicio')

@section('content')

<section class="hero">
    <h2>Seguridad y Confianza para tu Hogar y Empresa</h2>
    <p>Soluciones profesionales de cerrajería con más de 10 años de experiencia en el sector</p>
    <div class="hero-buttons">
        <a href="#servicios">
            <button class="btn-primary">Descubrir Servicios <i class="fas fa-arrow-right"></i></button>
        </a>
        <a href="#productos">
            <button class="btn-secondary">Ver Productos <i class="fas fa-shopping-cart"></i></button>
        </a>
    </div>
</section>

<section id="servicios" class="services">
    <div class="container">
        <div class="section-header">
            <h2>Nuestros Servicios</h2>
            <p>Ofrecemos servicios especializados de cerrajería para garantizar la seguridad de su hogar o negocio</p>
        </div>
        
       <div class="servicios-grid">
    @foreach($services as $service)
    <div class="servicio">
        @if($service->name == 'Apertura de Puertas')
            <img src="{{ asset('imagenes/imagenes/img/apertura3.jpg') }}" alt="Apertura de puertas">
        @elseif($service->name == 'Cambio de Cerraduras')
            <img src="{{ asset('imagenes/imagenes/img/cerradura.jpg') }}" alt="Cambio de cerraduras">
        @elseif($service->name == 'Sistemas de Seguridad')
            <img src="{{ asset('imagenes/imagenes/img/insta.jpg') }}" alt="Sistemas de seguridad">
        @elseif($service->name == 'Copia de Llaves')
            <img src="{{ asset('imagenes/imagenes/img/llave.jpg') }}" alt="Copia de llaves">
        @elseif($service->name == 'Mantenimiento de Cerraduras')
            <img src="{{ asset('imagenes/mantenimiento.jpg') }}" alt="Mantenimiento de cerraduras">
        @elseif($service->name == 'Instalación de Cajas Fuertes')
            <img src="{{ asset('imagenes/cajafuerte2.png') }}" alt="Instalación de cajas fuertes">
        @else
            <img src="{{ asset('imagenes/img/default.jpg') }}" alt="{{ $service->name }}">
        @endif
        <div class="servicio-content">
            <h3>{{ $service->name }}</h3>
            <p>{{ $service->description }}</p>
            @if($service->base_price)
                <p class="service-price">Desde {{ $service->formatted_price }}</p>
            @endif
            <a href="{{ route('appointments.create') }}?service={{ $service->id }}" class="servicio-link">
                Solicitar servicio <i class="fas fa-angle-right"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>
</section>

<section id="productos" class="productos">
    <div class="container">
        <div class="section-header">
            <h2>Nuestros Productos</h2>
            <p>Ofrecemos una amplia gama de productos de cerrajería de alta calidad para garantizar la seguridad de su hogar o negocio</p>
        </div>
        
        <div class="productos-categorias">
            <ul class="tabs">
                <li class="tab-item active" data-category="todos">Todos</li>
                <li class="tab-item" data-category="cerraduras">Cerraduras</li>
                <li class="tab-item" data-category="accesorios">Accesorios</li>
            </ul>
        </div>
        
        <div class="productos-grid">
            <div class="producto" data-category="cerraduras">
                <div class="producto-img">
                    <span class="tag">Destacado</span>
                    <img src="{{ asset('imagenes/imagenes/img/multipunto.jpeg') }}" alt="Cerradura de alta seguridad">
                </div>
                <div class="producto-content">
                    <h3>Cerradura Multipunto</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(4.5/5)</span>
                    </div>
                    <p>Cerradura de seguridad con sistema multipunto para puertas principales. Resistente a intrusiones y manipulaciones.</p>
                    <div class="producto-footer">
                        <div class="precio">$200.000</div>
                        <div class="producto-buttons">
                            <button class="btn-consultar" onclick="openInquiryModal('Cerradura Multipunto', 200000)">
                                <i class="fas fa-comments"></i> Consultar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="producto" data-category="cerraduras">
                <div class="producto-img">
                    <img src="{{ asset('imagenes/imagenes/img/digital.png') }}" alt="Cerradura digital">
                </div>
                <div class="producto-content">
                    <h3>Cerradura Digital con Huella</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span>(5/5)</span>
                    </div>
                    <p>Cerradura inteligente con reconocimiento de huella dactilar, código PIN y llave de emergencia.</p>
                    <div class="producto-footer">
                        <div class="precio">$800.000</div>
                        <div class="producto-buttons">
                            <button class="btn-consultar" onclick="openInquiryModal('Cerradura inteligente', 800000)">
                                <i class="fas fa-comments"></i> Consultar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="producto" data-category="cerraduras">
                <div class="producto-img">
                    <img src="{{ asset('imagenes/imagenes/img/cristal.png') }}" alt="Cerradura cristal">
                </div>
                <div class="producto-content">
                    <h3>Cerradura para Puerta de Cristal</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <span>(4/5)</span>
                    </div>
                    <p>Sistema de cerradura especial para puertas de cristal con acabado en acero inoxidable.</p>
                    <div class="producto-footer">
                        <div class="precio">$150.000</div>
                        <div class="producto-buttons">
                            <button class="btn-consultar" onclick="openInquiryModal('Cerradura especial', 150000)">
                                <i class="fas fa-comments"></i> Consultar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="producto" data-category="accesorios">
                <div class="producto-img">
                    <img src="{{ asset('imagenes/imagenes/img/cajafuerte.jpeg') }}" alt="caja fuerte">
                </div>
                <div class="producto-content">
                    <h3>Caja Fuerte</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span>(5/5)</span>
                    </div>
                    <p>Caja fuerte con sistema de apertura digital y llave de emergencia. Ideal para hogares y oficinas.</p>
                    <div class="producto-footer">
                        <div class="precio">$2.000.000</div>
                        <div class="producto-buttons">
                            <button class="btn-consultar" onclick="openInquiryModal('Caja fuerte', 2000000)">
                                <i class="fas fa-comments"></i> Consultar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="producto" data-category="accesorios">
                <div class="producto-img">
                    <img src="{{ asset('imagenes/imagenes/img/cilindro2.jpeg') }}" alt="Cilindro">
                </div>
                <div class="producto-content">
                    <h3>Cilindro Antibumping</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(4.5/5)</span>
                    </div>
                    <p>Cilindro de alta seguridad resistente a técnicas de bumping, ganzúas y taladros.</p>
                    <div class="producto-footer">
                        <div class="precio">$250.000</div>
                        <div class="producto-buttons">
                            <button class="btn-consultar" onclick="openInquiryModal('Cilindro de alta seguridad', 250000)">
                                <i class="fas fa-comments"></i> Consultar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="producto" data-category="accesorios">
                <div class="producto-img">
                    <img src="{{ asset('imagenes/imagenes/img/candado.jpeg') }}" alt="candado">
                </div>
                <div class="producto-content">
                    <h3>Candado de Alta Seguridad</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <span>(4/5)</span>
                    </div>
                    <p>Candado reforzado con cuerpo de acero endurecido y arco protegido contra cortes.</p>
                    <div class="producto-footer">
                        <div class="precio">$300.000</div>
                        <div class="producto-buttons">
                            <button class="btn-consultar" onclick="openInquiryModal('Candado reforzado', 300000)">
                                <i class="fas fa-comments"></i> Consultar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="ver-mas-productos">
            <a href="{{ asset('catalogos/Catalogo/CATALOGOGM.pdf') }}" class="btn-secondary" target="_blank">
                Ver Catálogo Completo <i class="fas fa-file-pdf"></i>
            </a>
        </div>
    </div>
</section>

<section id="sobre-nosotros" class="sobre-nosotros">
    <div class="container">
        <div class="section-header">
            <h2>Sobre Nosotros</h2>
            <p>Conoce nuestro equipo y nuestra trayectoria en el sector de la seguridad</p>
        </div>
        
        <div class="about-content">
            <div class="about-img">
                <img src="{{ asset('imagenes/imagenes/img/tecnico.png') }}" alt="equipo">
            </div>
            
            <div class="about-text">
                <h3>Profesionales en Seguridad</h3>
                <p>En Gm Llaves y Cerraduras nos dedicamos a brindar soluciones de cerrajería confiables y eficientes desde hace más de una década. Nuestro equipo técnico está certificado y constantemente actualizado en las últimas tecnologías de seguridad.</p>
                
                <div class="about-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h4>Certificaciones de Seguridad</h4>
                            <p>Todos nuestros profesionales cuentan con certificaciones actualizadas del sector.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div>
                            <h4>Tecnología Avanzada</h4>
                            <p>Utilizamos equipos de última generación para todos nuestros servicios.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="testimonios" class="testimonios">
    <div class="container">
        <div class="section-header">
            <h2>Testimonios</h2>
            <p>Lo que nuestros clientes dicen sobre nuestros servicios</p>
        </div>
        
        <div class="testimonial-slider">
            <div class="testimonio">
                <div class="testimonio-content">
                    <p>"El servicio de emergencia fue excepcional. Llegaron en menos de 20 minutos y resolvieron el problema de mi puerta atascada con profesionalismo. Totalmente recomendados."</p>
                </div>
                <div class="client-info">
                    <span class="client-name">Carlos Ramírez</span>
                    <span>Propietario de vivienda</span>
                </div>
            </div>
            
            <div class="testimonio">
                <div class="testimonio-content">
                    <p>"Instalaron un sistema de seguridad completo en mi negocio. El trabajo fue impecable y el asesoramiento sobre qué tipo de cerraduras necesitaba fue muy valioso."</p>
                </div>
                <div class="client-info">
                    <span class="client-name">Laura González</span>
                    <span>Gerente de tienda</span>
                </div>
            </div>
            
            <div class="testimonio">
                <div class="testimonio-content">
                    <p>"Excelente servicio técnico. Cambiaron todas las cerraduras de mi casa tras una mudanza y me explicaron detalladamente cómo funcionaba cada sistema de seguridad."</p>
                </div>
                <div class="client-info">
                    <span class="client-name">Miguel Sánchez</span>
                    <span>Cliente residencial</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contacto" class="contacto">
    <div class="container">
        <div class="section-header">
            <h2>Contacto</h2>
            <p>¿Necesitas ayuda con tus cerraduras? Contáctanos hoy mismo</p>
        </div>
        
        <div class="contact-wrapper">
            <div class="contact-info">
                <h3>Información de Contacto</h3>
                <ul class="contact-details">
                    <li>
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h4>Teléfono</h4>
                            <p>+57 302 238 70 20</p>
                            <p>Servicio 24/7 para emergencias</p>
                        </div>
                    </li>
                    
                    <li>
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4>Correo Electrónico</h4>
                            <p>gmllaves@gmail.com</p>
                            <p>Respondemos en menos de 24 horas</p>
                        </div>
                    </li>
                    
                    <li>
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4>Ubicación</h4>
                            <p>Servicio a domicilio en toda la ciudad</p>
                        </div>
                    </li>
                </ul>
                
                <h4>Síguenos en Redes Sociales</h4>
                <ul class="social-icons">
                    <li><a href="https://facebook.com/gmllavesycerraduras" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://instagram.com/gmllavesycerraduras" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://wa.me/573022387020" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                </ul>
            </div>
            
            <div class="contact-form">
                <h3>Envíanos un Mensaje</h3>
                <form id="contactForm" action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="servicio">Servicio de Interés</label>
                        <select id="servicio" name="servicio" class="form-control" required>
                            <option value="">Seleccione un servicio</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" class="form-control" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn-primary btn-block">Enviar Mensaje <i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Modal de Consulta -->
<div id="inquiryModal" class="inquiry-modal" style="display: none;">
    <div class="inquiry-modal-content">
        <span class="close-inquiry" onclick="closeInquiryModal()">&times;</span>
        <h3>Consultar Producto</h3>
        <p id="modalProductName" style="color: #2c5aa0; font-weight: bold; margin-bottom: 20px;"></p>
        
        <form action="{{ route('inquiries.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_name" id="product_name">
            <input type="hidden" name="product_price" id="product_price">
            
            <div class="form-group">
                <label for="inq_client_name">Nombre Completo *</label>
                <input type="text" name="client_name" id="inq_client_name" class="form-control" 
                       value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
            </div>
            
            <div class="form-group">
                <label for="inq_client_email">Email *</label>
                <input type="email" name="client_email" id="inq_client_email" class="form-control"
                       value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
            </div>
            
            <div class="form-group">
                <label for="inq_client_phone">Teléfono *</label>
                <input type="tel" name="client_phone" id="inq_client_phone" class="form-control"
                       value="{{ auth()->check() ? auth()->user()->phone : '' }}" required>
            </div>
            
            <div class="form-group">
                <label for="message">Tu Consulta *</label>
                <textarea name="message" id="message" class="form-control" rows="4" 
                          placeholder="¿Qué te gustaría saber sobre este producto?" required></textarea>
            </div>
            
            <button type="submit" class="btn-primary btn-block">
                <i class="fas fa-paper-plane"></i> Enviar Consulta
            </button>
        </form>
    </div>
</div>


@endsection

@push('scripts')
<script>
    // Tabs de productos
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-item');
        const products = document.querySelectorAll('.producto');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const category = this.getAttribute('data-category');
                
                products.forEach(product => {
                    if (category === 'todos' || product.getAttribute('data-category') === category) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
        });
    });

    // Formulario de contacto
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('¡Gracias por contactarnos! Te responderemos a la brevedad.');
            contactForm.reset();
        });
    }

    // Modal de consultas de productos
    function openInquiryModal(productName, price) {
        document.getElementById('product_name').value = productName;
        document.getElementById('product_price').value = price;
        document.getElementById('modalProductName').textContent = productName + ' - $' + price.toLocaleString();
        document.getElementById('inquiryModal').style.display = 'flex';
    }

    function closeInquiryModal() {
        document.getElementById('inquiryModal').style.display = 'none';
    }

    document.getElementById('inquiryModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeInquiryModal();
        }
    });
</script>
@endpush