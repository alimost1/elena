<?php
/**
 * Template Name: Contact Page French
 *
 * @package Elena
 */

get_header();

$theme_uri = get_template_directory_uri();
$cf7_form  = get_post_meta(get_the_ID(), 'elena_cf7_shortcode', true);

if (!$cf7_form) {
    // Try to locate a CF7 form titled "Contact FR" first, otherwise fall back
    // to the first available CF7 form in the site.
    $cf7_candidate = get_page_by_title('Contact FR', OBJECT, 'wpcf7_contact_form');
    if (!$cf7_candidate) {
        $cf7_forms = get_posts(array(
            'post_type'      => 'wpcf7_contact_form',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'orderby'        => 'ID',
            'order'          => 'ASC',
        ));
        $cf7_candidate = !empty($cf7_forms) ? $cf7_forms[0] : null;
    }
    if ($cf7_candidate && function_exists('wpcf7_contact_form')) {
        $cf7_obj  = wpcf7_contact_form($cf7_candidate->ID);
        $hash_id  = $cf7_obj ? $cf7_obj->hash() : '';
        $cf7_form = $hash_id
            ? sprintf('[contact-form-7 id="%s" title="%s"]', esc_attr($hash_id), esc_attr($cf7_candidate->post_title))
            : sprintf('[contact-form-7 id="%d" title="%s"]', $cf7_candidate->ID, esc_attr($cf7_candidate->post_title));
    }
}
?>
<div class="elena-contact-page elena-section">
    <div class="elena-container">

        <header class="elena-contact-hero">
            <span class="elena-contact-eyebrow">Elena.ma</span>
            <h1 class="elena-contact-title">Contactez-nous</h1>
            <p class="elena-contact-subtitle">
                Une question, une commande ou un avis ? Notre équipe est à votre écoute du lundi au samedi, de 9h à 18h.
            </p>
        </header>

        <div class="elena-contact-grid">

            <aside class="elena-contact-info">
                <div class="elena-contact-card">
                    <div class="elena-contact-icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="m3 7 9 6 9-6"/>
                        </svg>
                    </div>
                    <div class="elena-contact-card-body">
                        <h3>E-mail</h3>
                        <a href="mailto:contact@elena.ma">contact@elena.ma</a>
                        <p class="elena-contact-muted">Réponse sous 24h ouvrées</p>
                    </div>
                </div>

                <div class="elena-contact-card">
                    <div class="elena-contact-icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <div class="elena-contact-card-body">
                        <h3>Téléphone</h3>
                        <a href="tel:+212687873820">+212 687 87 38 20</a>
                        <p class="elena-contact-muted">Lun – Sam, 9h – 18h</p>
                    </div>
                </div>

                <div class="elena-contact-card">
                    <div class="elena-contact-icon" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="elena-contact-card-body">
                        <h3>Horaires</h3>
                        <p>Lundi – Samedi : 9h – 18h</p>
                        <p class="elena-contact-muted">Dimanche : Fermé</p>
                    </div>
                </div>

                <div class="elena-contact-socials">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="https://wa.me/212687873820" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    </a>
                </div>
            </aside>

            <div class="elena-contact-form-wrap">
                <h2 class="elena-contact-form-title">Envoyez-nous un message</h2>
                <p class="elena-contact-form-sub">Remplissez le formulaire ci-dessous, nous vous répondrons dans les plus brefs délais.</p>
                <div class="elena-contact-form">
                    <?php
                    if ($cf7_form) {
                        echo do_shortcode($cf7_form);
                    } else {
                        echo '<p style="padding:20px;background:#fff3cd;border:1px solid #ffeeba;border-radius:4px;color:#856404;">';
                        echo 'Aucun formulaire de contact trouvé. Créez-en un dans <strong>Contact → Formulaires de contact</strong>.';
                        echo '</p>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.elena-contact-page { padding: 60px 0 90px; background: var(--elena-bg, #FAF8F5); }
.elena-contact-hero { text-align: center; max-width: 680px; margin: 0 auto 48px; }
.elena-contact-eyebrow { display: inline-block; font-size: .8rem; letter-spacing: .25em; text-transform: uppercase; color: var(--elena-orange, #8B2E3B); margin-bottom: 12px; font-weight: 600; }
.elena-contact-title { font-family: var(--elena-font-display, 'Playfair Display', serif); font-size: clamp(2.2rem, 4vw, 3.2rem); margin: 0 0 18px; color: var(--elena-text, #1C1917); }
.elena-contact-subtitle { color: var(--elena-text-muted, #78716C); font-size: 1.05rem; line-height: 1.7; }

.elena-contact-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 40px; align-items: start; }

.elena-contact-info { display: flex; flex-direction: column; gap: 18px; }
.elena-contact-card { display: flex; gap: 16px; padding: 22px; background: #fff; border: 1px solid var(--elena-border, #E7E0D8); border-radius: 6px; transition: box-shadow .25s ease, transform .25s ease; }
.elena-contact-card:hover { box-shadow: 0 10px 30px rgba(28,25,23,.08); transform: translateY(-2px); }
.elena-contact-icon { flex-shrink: 0; width: 48px; height: 48px; border-radius: 50%; background: var(--elena-bg-alt, #F3EDE6); color: var(--elena-orange, #8B2E3B); display: flex; align-items: center; justify-content: center; }
.elena-contact-card-body h3 { margin: 0 0 6px; font-size: 1rem; letter-spacing: .04em; text-transform: uppercase; color: var(--elena-text, #1C1917); }
.elena-contact-card-body a { color: var(--elena-text, #1C1917); text-decoration: none; font-weight: 600; font-size: 1.05rem; }
.elena-contact-card-body a:hover { color: var(--elena-orange, #8B2E3B); }
.elena-contact-card-body p { margin: 4px 0 0; font-size: .92rem; color: var(--elena-text, #1C1917); }
.elena-contact-muted { color: var(--elena-text-muted, #78716C) !important; font-size: .85rem !important; }

.elena-contact-socials { display: flex; gap: 12px; margin-top: 6px; }
.elena-contact-socials a { width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--elena-border, #E7E0D8); display: flex; align-items: center; justify-content: center; color: var(--elena-text, #1C1917); transition: all .25s ease; }
.elena-contact-socials a:hover { background: var(--elena-orange, #8B2E3B); color: #fff; border-color: var(--elena-orange, #8B2E3B); }

.elena-contact-form-wrap { background: #fff; border: 1px solid var(--elena-border, #E7E0D8); border-radius: 6px; padding: 40px; }
.elena-contact-form-title { font-family: var(--elena-font-display, 'Playfair Display', serif); margin: 0 0 8px; font-size: 1.75rem; }
.elena-contact-form-sub { color: var(--elena-text-muted, #78716C); margin: 0 0 28px; }

.elena-contact-form .wpcf7-form p { margin-bottom: 18px; }
.elena-contact-form input[type="text"],
.elena-contact-form input[type="email"],
.elena-contact-form input[type="tel"],
.elena-contact-form textarea,
.elena-contact-form select {
    width: 100%; padding: 14px 16px; border: 1px solid var(--elena-border, #E7E0D8);
    background: #FAF8F5; border-radius: 4px; font-family: inherit; font-size: .98rem;
    color: var(--elena-text, #1C1917); transition: border-color .2s, background .2s;
}
.elena-contact-form input:focus, .elena-contact-form textarea:focus, .elena-contact-form select:focus {
    outline: none; border-color: var(--elena-orange, #8B2E3B); background: #fff;
}
.elena-contact-form textarea { min-height: 140px; resize: vertical; }
.elena-contact-form .wpcf7-submit,
.elena-contact-form input[type="submit"] {
    background: var(--elena-orange, #8B2E3B); color: #fff; border: 0; padding: 14px 36px;
    font-weight: 600; letter-spacing: .08em; text-transform: uppercase; cursor: pointer;
    border-radius: 4px; transition: background .2s ease; font-size: .9rem;
}
.elena-contact-form .wpcf7-submit:hover,
.elena-contact-form input[type="submit"]:hover { background: var(--elena-orange-hover, #722433); }

@media (max-width: 860px) {
    .elena-contact-grid { grid-template-columns: 1fr; gap: 28px; }
    .elena-contact-form-wrap { padding: 28px 22px; }
}
</style>

<?php
get_footer();
