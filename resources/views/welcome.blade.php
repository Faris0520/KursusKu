<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kursusku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-inner">
            <div style="display:flex;align-items:center;gap:40px;">
                <a href="/" class="navbar-logo">Kursusku<span>.</span></a>
                <div class="navbar-links">
                    <a href="#" class="active">Home</a>
                    <a href="#">Course</a>
                    <a href="#">Bootcamp</a>
                    <a href="#">Page</a>
                    <a href="#">Blog</a>
                    <a href="#">Contact</a>
                </div>
            </div>
            <div class="navbar-actions">
                @auth
                    @php
                        $dashUrl = auth()->user()->isAdmin()
                            ? route('admin.dashboard')
                            : (auth()->user()->isMentor()
                                ? route('mentor.dashboard')
                                : route('siswa.dashboard'));
                    @endphp
                    <a href="{{ $dashUrl }}" class="btn-login">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-register">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-card">
                <div class="hero-text">
                    <h1>Perdalam Skillmu<br>di Kursusku!</h1>
                    <div class="hero-btns">
                        <a href="{{ route('register') }}" class="btn-hero-primary">Subscribe</a>
                        <a href="#featured" class="btn-hero-outline">Learn Now</a>
                    </div>
                </div>
                <div class="hero-img">
                    <img src="https://i.pinimg.com/1200x/0c/60/5f/0c605f5725146674637fe3342783ecf4.jpg" alt="Hero">
                </div>
            </div>
        </div>
    </section>

    <!-- Category Bar -->       
    <div class="category-bar">
        <div class="category-bar-inner">
            @php
            $cats = [
                ['name' => 'All Categories', 'd' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                ['name' => 'Business',       'd' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                ['name' => 'Development',    'd' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
                ['name' => 'Language',       'd' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'],
                ['name' => 'Marketing',      'd' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                ['name' => 'Finance',        'd' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['name' => 'Design',         'd' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
                ['name' => 'Photography',    'd' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zm7 5a2 2 0 114 0 2 2 0 01-4 0z'],
                ['name' => 'Office',         'd' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ];
            @endphp
            @foreach($cats as $cat)
            <a href="#" class="cat-item">
                <div class="cat-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cat['d'] }}"/>
                    </svg>
                </div>
                <span class="cat-name">{{ $cat['name'] }}</span>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Classes -->
    <section class="featured" id="featured">
        <div class="section">
            <h2 class="section-title">Featured classes</h2>
            <div class="courses-grid">
                @forelse($popularCourses as $c)
                @php $rating = round($c->averageRating(), 1); @endphp
                <a href="{{ route('courses.show', $c->slug) }}" class="course-card">
                    <div class="course-thumb">
                        @if($c->thumbnail)
                            <img src="{{ asset('storage/' . $c->thumbnail) }}" alt="{{ $c->title }}">
                        @else
                            <img src="https://placehold.co/280x148/e0e7ff/4f46e5?text={{ urlencode($c->category->name ?? 'Course') }}" alt="{{ $c->title }}">
                        @endif
                        <span class="badge-level">{{ $c->category->name ?? 'Course' }}</span>
                    </div>
                    <div class="course-body">
                        <div class="course-title">{{ $c->title }}</div>
                        <div class="course-author">By <span>{{ $c->mentor->name ?? 'Mentor' }}</span> · {{ $c->category->name ?? '-' }}</div>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="{{ $i <= floor($rating) ? 'star-on' : 'star-off' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                            <span class="rating-val">{{ $rating ?: 'Baru' }}</span>
                        </div>
                        <div class="course-price">
                            <span class="price-now">{{ $c->isFree() ? 'Gratis' : 'Rp ' . number_format($c->price, 0, ',', '.') }}</span>
                            <span class="price-was">{{ $c->enrollments_count ?? 0 }} siswa</span>
                        </div>
                    </div>
                </a>
                @empty
                <p style="color:#64748b;">Belum ada kursus yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Popular Classes -->
    <section class="popular">
        <div class="section">
            <h2 class="section-title">Popular classes</h2>
            <div class="popular-grid">
                @forelse($popularCourses->take(4) as $c)
                @php $rating = round($c->averageRating(), 1); @endphp
                <div class="popular-card">
                    <div class="course-thumb">
                        @if($c->thumbnail)
                            <img src="{{ asset('storage/' . $c->thumbnail) }}" alt="{{ $c->title }}">
                        @else
                            <img src="https://placehold.co/280x148/6366f1/ffffff?text={{ urlencode($c->category->name ?? 'Course') }}" alt="{{ $c->title }}">
                        @endif
                        <span class="badge-level">{{ $c->category->name ?? 'Course' }}</span>
                    </div>
                    <div class="course-body">
                        <div class="course-title">{{ $c->title }}</div>
                        <div class="course-author">By <span>{{ $c->mentor->name ?? 'Mentor' }}</span> · {{ $c->category->name ?? '-' }}</div>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="{{ $i <= floor($rating) ? 'star-on' : 'star-off' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                            <span class="rating-val">{{ $rating ?: 'Baru' }}</span>
                        </div>
                        <a href="{{ route('courses.show', $c->slug) }}" class="btn-start">Start Learning</a>
                    </div>
                </div>
                @empty
                <p style="color:#64748b;">Belum ada kursus populer.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Upskill -->
    <section class="why">
        <div class="section">
            <div class="why-inner">
                <div class="why-img">
                    <img src="https://placehold.co/540x380/f0f9ff/0284c7?text=Learning+Environment" alt="Learning Environment">
                </div>
                <div class="why-content">
                    <h2>Why Upskill becomes the best training course &amp; bootcamp.</h2>
                    <div class="why-grid">
                        @php
                        $feats = [
                            ['title' => 'Intensive Learning', 'desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ut aliquam.'],
                            ['title' => 'Growth Mindset',     'desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ut aliquam.'],
                            ['title' => 'Relevant Skill',     'desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ut aliquam.'],
                            ['title' => 'Relevant Skill',     'desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ut aliquam.'],
                        ];
                        @endphp
                        @foreach($feats as $f)
                        <div class="why-feat">
                            <div class="check-wrap">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="feat-text">
                                <h4>{{ $f['title'] }}</h4>
                                <p>{{ $f['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Banners -->  
    <section class="promo">
        <div class="section">
            <div class="promo-grid">
                <div class="promo-card promo-1">
                    <div class="promo-text">
                        <h3>Learning Bootcamp<br>&amp; program</h3>
                        <a href="#" class="btn-promo">Read More</a>
                    </div>
                    <div class="promo-img">
                        <img src="https://placehold.co/120x120/0f766e/ccfbf1?text=Bootcamp" alt="Bootcamp">
                    </div>
                </div>
                <div class="promo-card promo-2">
                    <div class="promo-text">
                        <h3>Professional<br>Development</h3>
                        <a href="#" class="btn-promo">Read More</a>
                    </div>
                    <div class="promo-img">
                        <img src="https://placehold.co/120x120/4338ca/e0e7ff?text=Professional" alt="Professional">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner Logos -->
    <div class="partners">
        <div class="partners-inner">
            @foreach(['◎ Vision', '⬡ Product', '✦ Sitemark', '→ Nextmove', '⬢ Network', '△ Penta'] as $p)
            <span class="partner-name">{{ $p }}</span>
            @endforeach
        </div>
    </div>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="section">
            <div class="testi-grid">
                @php
                $testis = [
                    ['name' => 'Benjamin Reed',   'text' => "Upskill's training exceeded expectations. Exceptional instructors, real-world focus. A pivotal step toward career advancement."],
                    ['name' => 'Olivia Carter',   'text' => "Thrilled with Upskill's program. Invaluable knowledge, seamless delivery. Elevate your skills and future prospects confidently."],
                    ['name' => 'Daniel Mitchell', 'text' => "Outstanding training by Upskill. Real-world applications, transformative impact. Boosted my career and competency significantly."],
                ];
                @endphp
                @foreach($testis as $t)
                <div class="testi-card">
                    <p class="testi-text">"{{ $t['text'] }}"</p>
                    <div class="testi-author">
                        <div class="testi-avatar">
                            <img src="https://placehold.co/44x44/e2e8f0/64748b?text={{ substr($t['name'],0,1) }}" alt="{{ $t['name'] }}">
                        </div>
                        <div>
                            <div class="testi-stars">
                                @for($i = 0; $i < 5; $i++)
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                            <div class="testi-name">{{ $t['name'] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="cta">
        <div class="cta-inner">
            <div class="cta-text">
                <h2><mark>Launch Your Career Journey</mark><br>through upskill.</h2>
                <a href="{{ route('register') }}" class="btn-cta">Register Now</a>
            </div>
            <div class="cta-img">
                <img src="https://placehold.co/300x220/1e40af/93c5fd?text=Career+Journey" alt="Career">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <!-- Brand -->
                <div>
                    <a href="/" class="footer-logo">upskill<span>.</span></a>
                    <div class="footer-contact">
                        <div class="contact-row">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            0812 9999 9976
                        </div>
                        <div class="contact-row">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            info@upskill.com
                        </div>
                    </div>
                </div>
                <!-- Company -->
                <div class="footer-col">
                    <h5>Company</h5>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">What We Offer</a></li>
                        <li><a href="#">Our Course</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <!-- Teaching -->
                <div class="footer-col">
                    <h5>Teaching</h5>
                    <ul>
                        <li><a href="#">Become a Teacher</a></li>
                        <li><a href="#">Teacher Help Center</a></li>
                        <li><a href="#">Rules &amp; Requirements</a></li>
                        <li><a href="#">Leadership</a></li>
                    </ul>
                </div>
                <!-- Community -->
                <div class="footer-col">
                    <h5>Community</h5>
                    <ul>
                        <li><a href="#">Learners</a></li>
                        <li><a href="#">Partners</a></li>
                        <li><a href="#">Blog &amp; News</a></li>
                        <li><a href="#">Team Plans</a></li>
                    </ul>
                </div>
                <!-- Connect -->
                <div class="footer-col">
                    <h5>Connect with us</h5>
                    <div class="social-row">
                        <a href="#" class="social-btn" style="background:#1877f2;" title="Facebook">
                            <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="social-btn" style="background:#1da1f2;" title="Twitter">
                            <svg viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="social-btn" style="background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);" title="Instagram">
                            <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="social-btn" style="background:#ff0000;" title="YouTube">
                            <svg viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-links">
                    <a href="#">Privacy Practices</a>
                    <a href="#">Disclaimer</a>
                    <a href="#">Accessibility</a>
                    <a href="#">Terms of Use</a>
                    <a href="#">Sitemap</a>
                </div>
                <span class="footer-copy">Copyright &copy; 2024 Upskill &middot; Powered by Onecontributor</span>
            </div>
        </div>
    </footer>

</body>
</html>
