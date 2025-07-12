<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGESEC - Sistema de Gestión de Zonas Seguras</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2D5F8B;
            --primary-dark: #1E4A6F;
            --secondary: #E74C3C;
            --accent: #F39C12;
            --light: #F8F9FA;
            --dark: #343A40;
            --success: #27AE60;
            --warning: #F1C40F;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            font-size: 1.25rem;
        }
        
        .logo img {
            height: 2.5rem;
        }
        
        .nav-links {
            display: flex;
            gap: 1.5rem;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background-color: var(--accent);
            color: white;
            border: 2px solid var(--accent);
        }
        
        .btn-primary:hover {
            background-color: #e67e22;
            border-color: #e67e22;
        }
        
        .btn-outline {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .hero {
            position: relative;
            height: 70vh;
            min-height: 500px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3));
            z-index: 1;
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 2rem;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        .features {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 3rem;
            color: var(--primary);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }
        
        .feature-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .feature-content {
            padding: 1.5rem;
        }
        
        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--primary);
        }
        
        .feature-desc {
            color: #666;
            margin-bottom: 1rem;
        }
        
        .map-section {
            background-color: var(--primary);
            color: white;
            padding: 5rem 2rem;
            text-align: center;
        }
        
        .map-container {
            max-width: 1000px;
            margin: 2rem auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }
        
        .map-container img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .testimonials {
            padding: 5rem 2rem;
            background-color: #f5f7fa;
        }
        
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .testimonial-card {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 1.5rem;
            color: #555;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .author-info h4 {
            margin: 0;
            font-weight: 600;
        }
        
        .author-info p {
            margin: 0;
            color: #777;
            font-size: 0.9rem;
        }
        
        .cta {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 5rem 2rem;
            text-align: center;
        }
        
        .cta-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .footer {
            background-color: var(--dark);
            color: white;
            padding: 3rem 2rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .footer-logo img {
            height: 2rem;
        }
        
        .footer-about {
            max-width: 300px;
        }
        
        .footer-links h3 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.5rem;
        }
        
        .footer-links a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .footer-contact p {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            color: #aaa;
        }
        
        @media (max-width: 768px) {
            .nav {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-links {
                flex-direction: column;
                gap: 0.5rem;
                width: 100%;
            }
            
            .nav-link {
                text-align: center;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <div class="logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e8/Flag_of_Ecuador.svg" alt="Bandera Ecuador">
                <span>SIGESEC</span>
            </div>
            <div class="nav-links">
                <a href="#" class="nav-link">Inicio</a>
                <a href="{{ route('seguras.pdf') }}" class="nav-link">Zonas Seguras</a>
                <a href="#" class="nav-link">Mapas</a>
                <a href="#" class="nav-link">Recursos</a>
                <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
            </div>
        </nav>
    </header>
    
    <section class="hero">
        <img src="https://quitotourbus.com/wp-content/uploads/2019/04/parquer-nacional-cotopaxi.jpg" alt="Volcán Cotopaxi" class="hero-bg">
        <div class="hero-content">
            <h1 class="hero-title">Sistema Integral de Gestión de Zonas Seguras</h1>
            <p class="hero-subtitle">Protegiendo a las comunidades ecuatorianas mediante la identificación y gestión de zonas de seguridad ante emergencias</p>
            <div class="hero-buttons">
                <a href="#" class="btn btn-primary">Explorar Mapa</a>
                <a href="#" class="btn btn-outline">Aprender Más</a>
            </div>
        </div>
    </section>
    
    <section class="features">
        <h2 class="section-title">Nuestras Características</h2>
        <div class="features-grid">
            <div class="feature-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTASW6O1wJ1TOw2o8d9C7vD_zvSejf6jxhExA&s">
                <div class="feature-content">
                    <h3 class="feature-title">Mapa Interactivo</h3>
                    <p class="feature-desc">Visualiza en tiempo real todas las zonas seguras y puntos de encuentro en tu localidad con nuestro mapa georreferenciado.</p>
                    <a href="#" class="btn btn-primary">Ver Mapa</a>
                </div>
            </div>
            
            <div class="feature-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJskvUVhqHvmFchKZ1VHSm6VrIPbks2bZUIg&s" alt="Alertas tempranas" class="feature-img">
                <div class="feature-content">
                    <h3 class="feature-title">Alertas Tempranas de Zonas Seguras</h3>
                    <p class="feature-desc">Recibe notificaciones instantáneas sobre emergencias y las rutas más seguras hacia los puntos de encuentro designados.</p>
                    <a href="{{ route('seguras.pdf') }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf"></i> Generar PDF
                        </a>
                        <button id="btnGenerarPDF" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Generar PDF
                        </button>
                        <a href="{{ route('seguras.pdf') }}" id="btnGenerarPDF" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Generar PDFF
                        </a>

                        <script>
                            document.getElementById('btnGenerarPDF').addEventListener('click', function () {
                                html2canvas(document.getElementById('mapaZonas')).then(function (canvas) {
                                    const imageData = canvas.toDataURL('image/png');

                                    // Enviar imagen al backend
                                    fetch('{{ route("seguras.enviarMapa") }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({ imagen: imageData })
                                    })
                                    .then(response => response.blob())
                                    .then(blob => {
                                        // Descargar automáticamente el PDF
                                        const url = window.URL.createObjectURL(blob);
                                        const a = document.createElement('a');
                                        a.href = url;
                                        a.download = 'zonas_seguras.pdf';
                                        document.body.appendChild(a);
                                        a.click();
                                        a.remove();
                                    });
                                });
                            });
                            </script>

                    <a href="{{ route('seguras.index') }}" class="btn btn-secondary mt-2">Zonas seguras</a>
                </div>
            </div>
            
            <div class="feature-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQlQxHP4dG1fRGcaxw_odWPtddnSEUbo6OIlQ&s" alt="Comunidad" class="feature-img">
                <div class="feature-content">
                    <h3 class="feature-title">Participación Comunitaria</h3>
                    <p class="feature-desc">Contribuye reportando nuevas zonas seguras o actualizando la información existente para beneficio de toda la comunidad.</p>
                    <a href="#" class="btn btn-primary">Contribuir</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="map-section">
        <h2 class="section-title" style="color: white;">Zonas Seguras en Ecuador</h2>
        <p>Explora nuestro mapa nacional de zonas de seguridad verificadas por autoridades locales</p>
        <div class="map-container">
            <img src="https://pbs.twimg.com/media/EEL5nG1W4AUSKqB?format=jpg&name=4096x4096">
        </div>
    </section>
    
    <section class="testimonials">
        <h2 class="section-title">Testimonios</h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <p class="testimonial-text">"Gracias a este sistema, nuestra comunidad en Quito pudo evacuar de manera ordenada durante el último simulacro de terremoto."</p>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="María González" class="author-avatar">
                    <div class="author-info">
                        <h4>María González</h4>
                        <p>Líder comunitaria, Quito</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">"Como bombero, este sistema nos ha permitido coordinar mejor las evacuaciones y saber exactamente dónde dirigir a la población."</p>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Carlos Mendoza" class="author-avatar">
                    <div class="author-info">
                        <h4>Carlos Mendoza</h4>
                        <p>Cuerpo de Bomberos, Guayaquil</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">"En mi escuela usamos el mapa para enseñar a los niños sobre seguridad y prevención de riesgos. ¡Una herramienta educativa excelente!"</p>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Luisa Torres" class="author-avatar">
                    <div class="author-info">
                        <h4>Luisa Torres</h4>
                        <p>Docente, Cuenca</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="cta">
        <h2 class="cta-title">¿Listo para proteger a tu comunidad?</h2>
        <p>Regístrate ahora y comienza a explorar las zonas seguras más cercanas a ti</p>
        <div class="cta-buttons">
            <a href="{{ route('register') }}" class="btn btn-primary">Registrarse Gratis</a>
            <a href="#" class="btn btn-outline">Ver Demo</a>
        </div>
    </section>
    
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-about">
                <div class="footer-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e8/Flag_of_Ecuador.svg" alt="Bandera Ecuador">
                    <span>SIGESEC</span>
                </div>
                <p>Sistema Integral de Gestión de Zonas de Seguridad y Puntos de Encuentro Comunitarios en Ecuador.</p>
            </div>
            
            <div class="footer-links">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Mapa de Zonas</a></li>
                    <li><a href="#">Recursos Educativos</a></li>
                    <li><a href="#">Preguntas Frecuentes</a></li>
                </ul>
            </div>
            
            <div class="footer-links">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Términos de Uso</a></li>
                    <li><a href="#">Política de Privacidad</a></li>
                    <li><a href="#">Aviso Legal</a></li>
                </ul>
            </div>
            
            <div class="footer-contact">
                <h3>Contacto</h3>
                <p><i class="fas fa-map-marker-alt"></i> Av. Amazonas N34-451, Quito</p>
                <p><i class="fas fa-phone"></i> (02) 222-2222</p>
                <p><i class="fas fa-envelope"></i> info@sigesec.gob.ec</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 SIGESEC - Sistema de Gestión de Zonas Seguras. Realizado por Adriana Quishpe.</p>
        </div>
    </footer>
</body>
</html>