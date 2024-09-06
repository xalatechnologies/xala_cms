<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main Menu
        $Menu1 = new Menu();
        $Menu1->row_no = 1;
        $Menu1->father_id = 0;
        $Menu1->title_ar = "القائمة الرئيسية";
        $Menu1->title_en = "Main Menu";
        $Menu1->title_ch = "主菜单";
        $Menu1->title_hi = "मुख्य मेन्यू";
        $Menu1->title_es = "Menú principal";
        $Menu1->title_ru = "Главное меню";
        $Menu1->title_pt = "Menu principal";
        $Menu1->title_fr = "Menu principal";
        $Menu1->title_de = "Hauptmenü";
        $Menu1->title_th = "เมนูหลัก";
        $Menu1->title_br = "Menu principal";
        $Menu1->status = 1;
        $Menu1->type = 0;
        $Menu1->cat_id = 0;
        $Menu1->link = "";
        $Menu1->created_by = 1;
        $Menu1->save();

        // Footer Menu
        $Menu2 = new Menu();
        $Menu2->row_no = 2;
        $Menu2->father_id = 0;
        $Menu2->title_ar = "قائمة الفوتر";
        $Menu2->title_en = "Footer Menu";
        $Menu2->title_ch = "页脚";
        $Menu2->title_hi = "फ़ुटबाल";
        $Menu2->title_es = "Pie de página";
        $Menu2->title_ru = "Нижний колонтитул";
        $Menu2->title_pt = "Rodapé";
        $Menu2->title_fr = "Bas de page";
        $Menu2->title_de = "Fusszeile";
        $Menu2->title_th = "เมนูส่วนท้าย";
        $Menu2->title_br = "Rodapé";
        $Menu2->status = 1;
        $Menu2->type = 0;
        $Menu2->cat_id = 0;
        $Menu2->link = "";
        $Menu2->created_by = 1;
        $Menu2->save();

        // Home
        $Menu = new Menu();
        $Menu->row_no = 1;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "الرئيسية";
        $Menu->title_en = "Home";
        $Menu->title_ch = "家";
        $Menu->title_hi = "घर";
        $Menu->title_es = "Casa";
        $Menu->title_ru = "Дом";
        $Menu->title_pt = "Lar";
        $Menu->title_fr = "Domicile";
        $Menu->title_de = "Home";
        $Menu->title_th = "บ้าน";
        $Menu->title_br = "Principal";
        $Menu->status = 1;
        $Menu->type = 1;
        $Menu->cat_id = 0;
        $Menu->link = "/";
        $Menu->link_ar = "/";
        $Menu->link_en = "/";
        $Menu->link_ch = "/";
        $Menu->link_hi = "/";
        $Menu->link_es = "/";
        $Menu->link_ru = "/";
        $Menu->link_pt = "/";
        $Menu->link_fr = "/";
        $Menu->link_de = "/";
        $Menu->link_th = "/";
        $Menu->link_br = "/";
        $Menu->created_by = 1;
        $Menu->save();

        // About
        $Menu = new Menu();
        $Menu->row_no = 2;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "من نحن";
        $Menu->title_en = "About";
        $Menu->title_ch = "关于我们";
        $Menu->title_hi = "के बारे में";
        $Menu->title_es = "Acerca de";
        $Menu->title_ru = "О нас";
        $Menu->title_pt = "Cerca de";
        $Menu->title_fr = "À propos";
        $Menu->title_de = "Über uns";
        $Menu->title_th = "เกี่ยวกับ";
        $Menu->title_br = "Sobre nós";
        $Menu->status = 1;
        $Menu->type = 0;
        $Menu->cat_id = 0;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Services
        $Menu = new Menu();
        $Menu->row_no = 3;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "خدماتنا";
        $Menu->title_en = "Services";
        $Menu->title_ch = "服务";
        $Menu->title_hi = "सेवाएं";
        $Menu->title_es = "Servicios";
        $Menu->title_ru = "Услуги";
        $Menu->title_pt = "Serviços";
        $Menu->title_fr = "services";
        $Menu->title_de = "Services";
        $Menu->title_th = "Services";
        $Menu->title_br = "Serviços";
        $Menu->status = 1;
        $Menu->type = 3;
        $Menu->cat_id = 2;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // News
        $Menu = new Menu();
        $Menu->row_no = 5;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "أخبارنا";
        $Menu->title_en = "News";
        $Menu->title_ch = "新闻";
        $Menu->title_hi = "समाचार";
        $Menu->title_es = "Noticias";
        $Menu->title_ru = "Новости";
        $Menu->title_pt = "Notícia";
        $Menu->title_fr = "Nouvelles";
        $Menu->title_de = "News";
        $Menu->title_th = "ข่าว";
        $Menu->title_br = "Notícias";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 3;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Photos
        $Menu = new Menu();
        $Menu->row_no = 6;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "الصور";
        $Menu->title_en = "Photos";
        $Menu->title_ch = "照片";
        $Menu->title_hi = "तस्वीरें";
        $Menu->title_es = "Fotos";
        $Menu->title_ru = "Фото";
        $Menu->title_pt = "Fotos";
        $Menu->title_fr = "Photos";
        $Menu->title_de = "Fotos";
        $Menu->title_th = "照片";
        $Menu->title_br = "Fotos";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 4;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Videos
        $Menu = new Menu();
        $Menu->row_no = 7;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "الفيديو";
        $Menu->title_en = "Videos";
        $Menu->title_ch = "视频";
        $Menu->title_hi = "वीडियो";
        $Menu->title_es = "Videos";
        $Menu->title_ru = "Видео";
        $Menu->title_pt = "Vídeos";
        $Menu->title_fr = "Vidéos";
        $Menu->title_de = "Videos";
        $Menu->title_th = "วิดีโอ";
        $Menu->title_br = "Vídeos";
        $Menu->status = 1;
        $Menu->type = 3;
        $Menu->cat_id = 5;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Audio
        $Menu = new Menu();
        $Menu->row_no = 8;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "الصوتيات";
        $Menu->title_en = "Audio";
        $Menu->title_ch = "声音的";
        $Menu->title_hi = "ऑडियो";
        $Menu->title_es = "Audio";
        $Menu->title_ru = "Аудио";
        $Menu->title_pt = "Áudio";
        $Menu->title_fr = "l'audio";
        $Menu->title_de = "Audio";
        $Menu->title_th = "เครื่องเสียง";
        $Menu->title_br = "áudio";
        $Menu->status = 1;
        $Menu->type = 3;
        $Menu->cat_id = 6;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Products
        $Menu = new Menu();
        $Menu->row_no = 4;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "المنتجات";
        $Menu->title_en = "Products";
        $Menu->title_ch = "产品";
        $Menu->title_hi = "उत्पादों";
        $Menu->title_es = "Productos";
        $Menu->title_ru = "Товары";
        $Menu->title_pt = "Produtos";
        $Menu->title_fr = "Produits";
        $Menu->title_de = "Produkte";
        $Menu->title_th = "สินค้า";
        $Menu->title_br = "Produtos";
        $Menu->status = 1;
        $Menu->type = 3;
        $Menu->cat_id = 8;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Blog
        $Menu = new Menu();
        $Menu->row_no = 9;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "المدونة";
        $Menu->title_en = "Blog";
        $Menu->title_ch = "博客";
        $Menu->title_hi = "ब्लॉग";
        $Menu->title_es = "Blog";
        $Menu->title_ru = "Блог";
        $Menu->title_pt = "Blog";
        $Menu->title_fr = "Blog";
        $Menu->title_de = "Blog";
        $Menu->title_th = "บล็อก";
        $Menu->title_br = "blog";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 7;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // FAQ
        $Menu = new Menu();
        $Menu->row_no = 10;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "الأسئلة الشائعة";
        $Menu->title_en = "FAQ";
        $Menu->title_ch = "常问问题";
        $Menu->title_hi = "सामान्य प्रश्न";
        $Menu->title_es = "FAQ";
        $Menu->title_ru = "FAQ";
        $Menu->title_pt = "FAQ";
        $Menu->title_fr = "FAQ";
        $Menu->title_de = "FAQ";
        $Menu->title_th = "คำถามที่พบบ่อย";
        $Menu->title_br = "FAQ";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 10;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Contact
        $Menu = new Menu();
        $Menu->row_no = 11;
        $Menu->father_id = $Menu1->id;
        $Menu->title_ar = "اتصل بنا";
        $Menu->title_en = "Contact";
        $Menu->title_ch = "接触";
        $Menu->title_hi = "संपर्क करें";
        $Menu->title_es = "Contacto";
        $Menu->title_ru = "Контакт";
        $Menu->title_pt = "Contato";
        $Menu->title_fr = "Contact";
        $Menu->title_de = "Kontakt";
        $Menu->title_th = "ติดต่อ";
        $Menu->title_br = "Contato";
        $Menu->status = 1;
        $Menu->type = 1;
        $Menu->cat_id = 0;
        $Menu->link = "contact";
        $Menu->link_ar = "اتصل-بنا";
        $Menu->link_en = "contact";
        $Menu->link_ch = "接触";
        $Menu->link_hi = "संपर्क";
        $Menu->link_es = "contacto";
        $Menu->link_ru = "контакт";
        $Menu->link_pt = "contato";
        $Menu->link_fr = "Contactez-nous";
        $Menu->link_de = "kontaktiere-uns";
        $Menu->link_th = "ติดต่อเรา";
        $Menu->link_br = "Contate-nos";
        $Menu->created_by = 1;
        $Menu->save();


        // About sub link 1
        $Menu = new Menu();
        $Menu->row_no = 1;
        $Menu->father_id = 4;
        $Menu->title_ar = "ملف الشركة";
        $Menu->title_en = "Company profile";
        $Menu->title_ch = "公司简介";
        $Menu->title_hi = "कंपनी प्रोफाइल";
        $Menu->title_es = "Perfil de la empresa";
        $Menu->title_ru = "Профиль компании";
        $Menu->title_pt = "Perfil de companhia";
        $Menu->title_fr = "Profil de l'entreprise";
        $Menu->title_de = "Unternehmensprofil";
        $Menu->title_th = "ประวัติบริษัท";
        $Menu->title_br = "Perfil de companhia";
        $Menu->icon = "fa-bookmark-o";
        $Menu->status = 1;
        $Menu->type = 1;
        $Menu->cat_id = 0;
        $Menu->link = "about";
        $Menu->link_ar = "من-نحن";
        $Menu->link_en = "about";
        $Menu->link_ch = "关于我们";
        $Menu->link_hi = "के बारे में";
        $Menu->link_es = "acerca-de";
        $Menu->link_ru = "о-нас";
        $Menu->link_pt = "sobre";
        $Menu->link_fr = "à-propos";
        $Menu->link_de = "um";
        $Menu->link_th = "เกี่ยวกับ";
        $Menu->link_br = "sobre-nós";
        $Menu->created_by = 1;
        $Menu->save();

        // About sub link 2
        $Menu = new Menu();
        $Menu->row_no = 1;
        $Menu->father_id = 4;
        $Menu->title_ar = "بيانات الفروع";
        $Menu->title_en = "Branches list";
        $Menu->title_ch = "分行列表";
        $Menu->title_hi = "शाखाओं की सूची";
        $Menu->title_es = "Lista de sucursales";
        $Menu->title_ru = "Список филиалов";
        $Menu->title_pt = "Lista de filiais";
        $Menu->title_fr = "Liste des succursales";
        $Menu->title_de = "Branchenliste";
        $Menu->title_th = "รายชื่อสาขา";
        $Menu->title_br = "Lista de filiais";
        $Menu->icon = "fa-table";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 13;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // About sub link 3
        $Menu = new Menu();
        $Menu->row_no = 1;
        $Menu->father_id = 4;
        $Menu->title_ar = "فريق العمل";
        $Menu->title_en = "Our Staff";
        $Menu->title_ch = "职员";
        $Menu->title_hi = "कर्मचारी";
        $Menu->title_es = "Personal";
        $Menu->title_ru = "Our Staff";
        $Menu->title_pt = "Funcionárias";
        $Menu->title_fr = "Personnelle";
        $Menu->title_de = "Mitarbeiterin";
        $Menu->title_th = "พนักงาน";
        $Menu->title_br = "Our Staff";
        $Menu->icon = "fa-user-circle-o";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 12;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // About sub link 4
        $Menu = new Menu();
        $Menu->row_no = 1;
        $Menu->father_id = 4;
        $Menu->title_ar = "أراء العملاء";
        $Menu->title_en = "Testimonials";
        $Menu->title_ch = "感言";
        $Menu->title_hi = "प्रशंसापत्र";
        $Menu->title_es = "Testimonios";
        $Menu->title_ru = "Testimonials";
        $Menu->title_pt = "Testimonials";
        $Menu->title_fr = "Témoignages";
        $Menu->title_de = "Referenzen";
        $Menu->title_th = "ข้อความรับรอง";
        $Menu->title_br = "Testimonials";
        $Menu->icon = "fa-star-o";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 11;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Footer Menu Sub links

        $Menu2sub1 = new Menu();
        $Menu2sub1->row_no = 2;
        $Menu2sub1->father_id = $Menu2->id;
        $Menu2sub1->title_ar = "عن الشركة";
        $Menu2sub1->title_en = "Our Company";
        $Menu2sub1->title_ch = "关于公司";
        $Menu2sub1->title_hi = "कम्पनी के बारे में";
        $Menu2sub1->title_es = "Acerca de la compañía";
        $Menu2sub1->title_ru = "О компании";
        $Menu2sub1->title_pt = "Sobre companhia";
        $Menu2sub1->title_fr = "À propos de la société";
        $Menu2sub1->title_de = "Über das Unternehmen";
        $Menu2sub1->title_th = "เกี่ยวกับบริษัท";
        $Menu2sub1->title_br = "Sobre companhia";
        $Menu2sub1->status = 1;
        $Menu2sub1->type = 0;
        $Menu2sub1->cat_id = 0;
        $Menu2sub1->link = "";
        $Menu2sub1->created_by = 1;
        $Menu2sub1->save();

        $Menu2sub2 = new Menu();
        $Menu2sub2->row_no = 2;
        $Menu2sub2->father_id = $Menu2->id;
        $Menu2sub2->title_ar = "روابط سريعة";
        $Menu2sub2->title_en = "Quick Links";
        $Menu2sub2->title_ch = "快速链接";
        $Menu2sub2->title_hi = "त्वरित सम्पक";
        $Menu2sub2->title_es = "enlaces rápidos";
        $Menu2sub2->title_ru = "Быстрые ссылки";
        $Menu2sub2->title_pt = "Links Rápidos";
        $Menu2sub2->title_fr = "Liens rapides";
        $Menu2sub2->title_de = "Quicklinks";
        $Menu2sub2->title_th = "ลิงค์ด่วน";
        $Menu2sub2->title_br = "Links Rápidos";
        $Menu2sub2->status = 1;
        $Menu2sub2->type = 0;
        $Menu2sub2->cat_id = 0;
        $Menu2sub2->link = "";
        $Menu2sub2->created_by = 1;
        $Menu2sub2->save();

        // About
        $Menu = new Menu();
        $Menu->row_no = 1;
        $Menu->father_id = $Menu2sub1->id;
        $Menu->title_ar = "من نحن";
        $Menu->title_en = "About";
        $Menu->title_ch = "关于";
        $Menu->title_hi = "के बारे में";
        $Menu->title_es = "Acerca de";
        $Menu->title_ru = "О";
        $Menu->title_pt = "Cerca de";
        $Menu->title_fr = "À propos";
        $Menu->title_de = "Über uns";
        $Menu->title_th = "เกี่ยวกับ";
        $Menu->title_br = "Sobre nós";
        $Menu->status = 1;
        $Menu->type = 1;
        $Menu->cat_id = 0;
        $Menu->link = "about";
        $Menu->link_ar = "من نحن";
        $Menu->link_en = "about";
        $Menu->link_ch = "关于我们";
        $Menu->link_hi = "के बारे में";
        $Menu->link_es = "acerca-de";
        $Menu->link_ru = "о-нас";
        $Menu->link_pt = "sobre";
        $Menu->link_fr = "à-propos";
        $Menu->link_de = "um";
        $Menu->link_th = "เกี่ยวกับ";
        $Menu->link_br = "sobre-nós";
        $Menu->created_by = 1;
        $Menu->save();

        // staff
        $Menu = new Menu();
        $Menu->row_no = 2;
        $Menu->father_id = $Menu2sub1->id;
        $Menu->title_ar = "فريق العمل";
        $Menu->title_en = "Our Staff";
        $Menu->title_ch = "职员";
        $Menu->title_hi = "कर्मचारी";
        $Menu->title_es = "Personal";
        $Menu->title_ru = "Our Staff";
        $Menu->title_pt = "Funcionárias";
        $Menu->title_fr = "Personnelle";
        $Menu->title_de = "Mitarbeiterin";
        $Menu->title_th = "พนักงาน";
        $Menu->title_br = "Our Staff";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 12;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Testimonials
        $Menu = new Menu();
        $Menu->row_no = 3;
        $Menu->father_id = $Menu2sub1->id;
        $Menu->title_ar = "أراء العملاء";
        $Menu->title_en = "Testimonials";
        $Menu->title_ch = "感言";
        $Menu->title_hi = "प्रशंसापत्र";
        $Menu->title_es = "Testimonios";
        $Menu->title_ru = "Testimonials";
        $Menu->title_pt = "Testimonials";
        $Menu->title_fr = "Témoignages";
        $Menu->title_de = "Referenzen";
        $Menu->title_th = "ข้อความรับรอง";
        $Menu->title_br = "Testimonials";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 11;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Privacy
        $Menu = new Menu();
        $Menu->row_no = 4;
        $Menu->father_id = $Menu2sub1->id;
        $Menu->title_ar = "الخصوصية";
        $Menu->title_en = "Privacy";
        $Menu->title_ch = "隐私";
        $Menu->title_hi = "गोपनीयता";
        $Menu->title_es = "Intimidad";
        $Menu->title_ru = "Конфиденциальность";
        $Menu->title_pt = "Privacidade";
        $Menu->title_fr = "Intimité";
        $Menu->title_de = "Datenschutz";
        $Menu->title_th = "ความเป็นส่วนตัว";
        $Menu->title_br = "Privacidade";
        $Menu->status = 1;
        $Menu->type = 1;
        $Menu->cat_id = 0;
        $Menu->link = "privacy";
        $Menu->link_ar = "الخصوصية";
        $Menu->link_en = "privacy";
        $Menu->link_ch = "隐私";
        $Menu->link_hi = "गोपनीयता";
        $Menu->link_es = "privacidad";
        $Menu->link_ru = "конфиденциальность";
        $Menu->link_pt = "privacidade";
        $Menu->link_fr = "confidentialité";
        $Menu->link_de = "Privatsphäre";
        $Menu->link_th = "ความเป็นส่วนตัว";
        $Menu->link_br = "privacidade-2";
        $Menu->created_by = 1;
        $Menu->save();

        // Terms
        $Menu = new Menu();
        $Menu->row_no = 5;
        $Menu->father_id = $Menu2sub1->id;
        $Menu->title_ar = "الشروط والأحكام";
        $Menu->title_en = "Terms & Conditions";
        $Menu->title_ch = "条款和条件";
        $Menu->title_hi = "नियम एवं शर्तें";
        $Menu->title_es = "Términos y condiciones";
        $Menu->title_ru = "Условия и положения";
        $Menu->title_pt = "termos e Condições";
        $Menu->title_fr = "termes et conditions";
        $Menu->title_de = "AGB";
        $Menu->title_th = "ข้อตกลงและเงื่อนไข";
        $Menu->title_br = "termos e Condições";
        $Menu->status = 1;
        $Menu->type = 1;
        $Menu->cat_id = 0;
        $Menu->link = "terms";
        $Menu->link_ar = "الشروط-والأحكام";
        $Menu->link_en = "terms";
        $Menu->link_ch = "条款";
        $Menu->link_hi = "शर्तें";
        $Menu->link_es = "términos";
        $Menu->link_ru = "условия";
        $Menu->link_pt = "termos";
        $Menu->link_fr = "termes";
        $Menu->link_de = "Bedingungen";
        $Menu->link_th = "เงื่อนไข";
        $Menu->link_br = "termos-2";
        $Menu->created_by = 1;
        $Menu->save();

        // Contact
        $Menu = new Menu();
        $Menu->row_no = 6;
        $Menu->father_id = $Menu2sub1->id;
        $Menu->title_ar = "اتصل بنا";
        $Menu->title_en = "Contact";
        $Menu->title_ch = "接触";
        $Menu->title_hi = "संपर्क करें";
        $Menu->title_es = "Contacto";
        $Menu->title_ru = "Контакт";
        $Menu->title_pt = "Contato";
        $Menu->title_fr = "Contact";
        $Menu->title_de = "Kontakt";
        $Menu->title_th = "ติดต่อ";
        $Menu->title_br = "Contato";
        $Menu->status = 1;
        $Menu->type = 1;
        $Menu->cat_id = 0;
        $Menu->link = "contact";
        $Menu->link_ar = "اتصل بنا";
        $Menu->link_en = "contact";
        $Menu->link_ch = "接触";
        $Menu->link_hi = "संपर्क";
        $Menu->link_es = "contacto";
        $Menu->link_ru = "контакт";
        $Menu->link_pt = "contato";
        $Menu->link_fr = "Contactez-nous";
        $Menu->link_de = "kontaktiere-uns";
        $Menu->link_th = "ติดต่อเรา";
        $Menu->link_br = "Contate-nos";
        $Menu->created_by = 1;
        $Menu->save();

        // Services
        $Menu = new Menu();
        $Menu->row_no = 1;
        $Menu->father_id = $Menu2sub2->id;
        $Menu->title_ar = "خدماتنا";
        $Menu->title_en = "Services";
        $Menu->title_ch = "服务";
        $Menu->title_hi = "सेवाएं";
        $Menu->title_es = "Servicios";
        $Menu->title_ru = "Услуги";
        $Menu->title_pt = "Serviços";
        $Menu->title_fr = "services";
        $Menu->title_de = "Services";
        $Menu->title_th = "Services";
        $Menu->title_br = "Serviços";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 2;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // products
        $Menu = new Menu();
        $Menu->row_no = 2;
        $Menu->father_id = $Menu2sub2->id;
        $Menu->title_ar = "المنتجات";
        $Menu->title_en = "Products";
        $Menu->title_ch = "产品";
        $Menu->title_hi = "उत्पादों";
        $Menu->title_es = "Productos";
        $Menu->title_ru = "Товары";
        $Menu->title_pt = "Produtos";
        $Menu->title_fr = "Produits";
        $Menu->title_de = "Produkte";
        $Menu->title_th = "สินค้า";
        $Menu->title_br = "Produtos";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 8;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // news
        $Menu = new Menu();
        $Menu->row_no = 3;
        $Menu->father_id = $Menu2sub2->id;
        $Menu->title_ar = "أخبارنا";
        $Menu->title_en = "News";
        $Menu->title_ch = "新闻";
        $Menu->title_hi = "समाचार";
        $Menu->title_es = "Noticias";
        $Menu->title_ru = "Новости";
        $Menu->title_pt = "Notícia";
        $Menu->title_fr = "Nouvelles";
        $Menu->title_de = "News";
        $Menu->title_th = "ข่าว";
        $Menu->title_br = "Notícias";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 3;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Blog
        $Menu = new Menu();
        $Menu->row_no = 4;
        $Menu->father_id = $Menu2sub2->id;
        $Menu->title_ar = "المدونة";
        $Menu->title_en = "Blog";
        $Menu->title_ch = "博客";
        $Menu->title_hi = "ब्लॉग";
        $Menu->title_es = "Blog";
        $Menu->title_ru = "Блог";
        $Menu->title_pt = "Blog";
        $Menu->title_fr = "Blog";
        $Menu->title_de = "Blog";
        $Menu->title_th = "บล็อก";
        $Menu->title_br = "blog";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 7;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Photos
        $Menu = new Menu();
        $Menu->row_no = 5;
        $Menu->father_id = $Menu2sub2->id;
        $Menu->title_ar = "الصور";
        $Menu->title_en = "Photos";
        $Menu->title_ch = "照片";
        $Menu->title_hi = "तस्वीरें";
        $Menu->title_es = "Fotos";
        $Menu->title_ru = "Фото";
        $Menu->title_pt = "Fotos";
        $Menu->title_fr = "Photos";
        $Menu->title_de = "Fotos";
        $Menu->title_th = "照片";
        $Menu->title_br = "Fotos";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 4;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

        // Videos
        $Menu = new Menu();
        $Menu->row_no = 6;
        $Menu->father_id = $Menu2sub2->id;
        $Menu->title_ar = "الفيديو";
        $Menu->title_en = "Videos";
        $Menu->title_ch = "视频";
        $Menu->title_hi = "वीडियो";
        $Menu->title_es = "Videos";
        $Menu->title_ru = "Видео";
        $Menu->title_pt = "Vídeos";
        $Menu->title_fr = "Vidéos";
        $Menu->title_de = "Videos";
        $Menu->title_th = "วิดีโอ";
        $Menu->title_br = "Vídeos";
        $Menu->status = 1;
        $Menu->type = 2;
        $Menu->cat_id = 5;
        $Menu->link = "";
        $Menu->created_by = 1;
        $Menu->save();

    }
}
