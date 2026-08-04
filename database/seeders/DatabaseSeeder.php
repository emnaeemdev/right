<?php

namespace Database\Seeders;

use App\Models\ConsultationRequest;
use App\Models\ContactMessage;
use App\Models\Expert;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Publication;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TrainingActivity;
use App\Models\TrainingBag;
use App\Models\TrainingBagCycleStep;
use App\Models\TrainingBagSample;
use App\Models\User;
use App\Models\VideoItem;
use App\Support\TrainingBagMeta;
use App\Support\TrainingBagSections;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRolesAndAdmin();
        $this->seedSettings();
        $this->seedServices();
        $this->seedExperts();
        $this->seedPartners();
        $this->seedProjects();
        $this->seedTrainingBags();
        $this->seedActivities();
        $this->seedVideos();
        $this->seedPublications();
    }

    private function seedRolesAndAdmin(): void
    {
        foreach (['super_admin', 'editor', 'viewer'] as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@right-center.org'],
            ['name' => 'RIGHT Admin', 'password' => Hash::make('password')]
        );
        $admin->assignRole('super_admin');
    }

    private function seedSettings(): void
    {
        Setting::set('site_name', [
            'ar' => 'مركز رايت للبحوث والاستشارات والتدريب',
            'en' => 'RIGHT Center for Research, Consultancy & Training',
        ]);
        Setting::set('stats', [
            'projects' => 50,
            'experts' => 15,
            'partners' => 30,
            'training_bags' => 25,
        ]);
    }

    public function seedServices(): void
    {
        $services = [
            [
                'title' => ['ar' => 'البحوث والدراسات', 'en' => 'Research & Studies'],
                'description' => ['ar' => 'إجراء بحوث ودراسات متخصصة لتقييم الواقع المؤسسي وتحديد الفجوات.', 'en' => 'Conducting specialized research and studies to assess institutional reality and identify gaps.'],
                'slug' => ['ar' => 'research', 'en' => 'research'],
            ],
            [
                'title' => ['ar' => 'الاستشارات المؤسسية', 'en' => 'Institutional Consultancy'],
                'description' => ['ar' => 'تقديم استشارات في الحوكمة وبناء القدرات وتطوير السياسات.', 'en' => 'Providing consultancy in governance, capacity building, and policy development.'],
                'slug' => ['ar' => 'consultancy', 'en' => 'consultancy'],
            ],
            [
                'title' => ['ar' => 'التدريب وبناء القدرات', 'en' => 'Training & Capacity Building'],
                'description' => ['ar' => 'تصميم وتنفيذ برامج تدريبية متخصصة بحقائب تدريبية معتمدة.', 'en' => 'Designing and delivering specialized training programs with certified training bags.'],
                'slug' => ['ar' => 'training', 'en' => 'training'],
            ],
            [
                'title' => ['ar' => 'المتابعة والتقييم', 'en' => 'Monitoring & Evaluation'],
                'description' => ['ar' => 'تصميم أنظمة M&E وإجراء تقييمات الأثر والاستدامة.', 'en' => 'Designing M&E systems and conducting impact and sustainability evaluations.'],
                'slug' => ['ar' => 'monitoring-evaluation', 'en' => 'monitoring-evaluation'],
            ],
        ];

        foreach ($services as $i => $data) {
            Service::create([...$data, 'sort_order' => $i + 1]);
        }
    }

    public function seedExperts(): void
    {
        $experts = [
            ['name' => ['ar' => 'د. أحمد محمود', 'en' => 'Dr. Ahmed Mahmoud'], 'title' => ['ar' => 'خبير التنمية المؤسسية', 'en' => 'Institutional Development Expert'], 'bio' => ['ar' => ' أكثر من 20 عاماً في تطوير المؤسسات الحكومية وغير الربحية.', 'en' => 'Over 20 years in developing government and non-profit institutions.']],
            ['name' => ['ar' => 'د. سارة الخطيب', 'en' => 'Dr. Sarah Al-Khatib'], 'title' => ['ar' => 'خبيرة المتابعة والتقييم', 'en' => 'M&E Expert'], 'bio' => ['ar' => 'متخصصة في تصميم أنظمة M&E وتقييم الأثر.', 'en' => 'Specialized in M&E system design and impact evaluation.']],
            ['name' => ['ar' => 'م. خالد العمري', 'en' => 'Eng. Khaled Al-Omari'], 'title' => ['ar' => 'خبير بناء القدرات', 'en' => 'Capacity Building Expert'], 'bio' => ['ar' => 'مدرب معتمد في TOT وتصميم الحقائب التدريبية.', 'en' => 'Certified TOT trainer and training bag designer.']],
            ['name' => ['ar' => 'د. نورا حسن', 'en' => 'Dr. Noura Hassan'], 'title' => ['ar' => 'خبيرة الحوكمة', 'en' => 'Governance Expert'], 'bio' => ['ar' => 'استشارية في الحوكمة الرشيدة وإدارة المخاطر.', 'en' => 'Consultant in good governance and risk management.']],
            ['name' => ['ar' => 'د. يوسف إبراهيم', 'en' => 'Dr. Youssef Ibrahim'], 'title' => ['ar' => 'خبير البحوث', 'en' => 'Research Expert'], 'bio' => ['ar' => 'باحث في السياسات العامة والتنمية المستدامة.', 'en' => 'Researcher in public policy and sustainable development.']],
            ['name' => ['ar' => 'أ. فاطمة الزهراء', 'en' => 'Ms. Fatima Al-Zahra'], 'title' => ['ar' => 'خبيرة التدريب', 'en' => 'Training Expert'], 'bio' => ['ar' => 'مدربة معتمدة في مهارات القيادة وإدارة الفرق.', 'en' => 'Certified trainer in leadership and team management skills.']],
        ];

        foreach ($experts as $i => $data) {
            Expert::create([...$data, 'sort_order' => $i + 1]);
        }
    }

    public function seedPartners(): void
    {
        $partners = [
            ['name' => ['ar' => 'وزارة التخطيط', 'en' => 'Ministry of Planning'], 'category' => 'gov'],
            ['name' => ['ar' => 'وزارة التضامن الاجتماعي', 'en' => 'Ministry of Social Solidarity'], 'category' => 'gov'],
            ['name' => ['ar' => 'برنامج الأمم المتحدة الإنمائي', 'en' => 'UNDP'], 'category' => 'intl'],
            ['name' => ['ar' => 'UNICEF', 'en' => 'UNICEF'], 'category' => 'intl'],
            ['name' => ['ar' => 'مؤسسة التنمية المحلية', 'en' => 'Local Development Foundation'], 'category' => 'ngo'],
            ['name' => ['ar' => 'جمعية رعاية الأسرة', 'en' => 'Family Care Association'], 'category' => 'ngo'],
            ['name' => ['ar' => 'الوكالة الأمريكية للتنمية', 'en' => 'USAID'], 'category' => 'intl'],
            ['name' => ['ar' => 'وزارة الشباب والرياضة', 'en' => 'Ministry of Youth & Sports'], 'category' => 'gov'],
        ];

        foreach ($partners as $i => $data) {
            Partner::create([...$data, 'sort_order' => $i + 1]);
        }
    }

    public function seedProjects(): void
    {
        $projects = [
            ['title' => ['ar' => 'تقييم القدرات المؤسسية لوزارة التضامن', 'en' => 'OCA for Ministry of Social Solidarity'], 'description' => ['ar' => 'تقييم شامل للقدرات المؤسسية ووضع خطة تطوير.', 'en' => 'Comprehensive OCA and development plan.'], 'slug' => ['ar' => 'oca-ministry-solidarity', 'en' => 'oca-ministry-solidarity'], 'client' => 'Ministry of Social Solidarity', 'field' => 'OCA', 'year' => 2024, 'is_featured' => true],
            ['title' => ['ar' => 'برنامج TOT لمدربي التنمية المحلية', 'en' => 'TOT for Local Development Trainers'], 'description' => ['ar' => 'تدريب 50 مدرباً على تصميم وتنفيذ برامج التنمية المحلية.', 'en' => 'Training 50 trainers on local development program design.'], 'slug' => ['ar' => 'tot-local-development', 'en' => 'tot-local-development'], 'client' => 'UNDP', 'field' => 'Training', 'year' => 2023, 'is_featured' => true],
            ['title' => ['ar' => 'تطوير نظام M&E للمؤسسات الأهلية', 'en' => 'M&E System for NGOs'], 'description' => ['ar' => 'تصميم وتطبيق نظام متابعة وتقييم لـ 30 مؤسسة أهلية.', 'en' => 'M&E system design for 30 NGOs.'], 'slug' => ['ar' => 'me-ngo-system', 'en' => 'me-ngo-system'], 'client' => 'USAID', 'field' => 'M&E', 'year' => 2023, 'is_featured' => true],
            ['title' => ['ar' => 'دراسة الحوكمة في القطاع غير الربحي', 'en' => 'Governance Study in Non-Profit Sector'], 'description' => ['ar' => 'بحث شامل عن ممارسات الحوكمة في 100 مؤسسة.', 'en' => 'Research on governance practices in 100 institutions.'], 'slug' => ['ar' => 'governance-study', 'en' => 'governance-study'], 'client' => 'Local Development Foundation', 'field' => 'Research', 'year' => 2022, 'is_featured' => false],
            ['title' => ['ar' => 'برنامج القيادة الإدارية', 'en' => 'Administrative Leadership Program'], 'description' => ['ar' => 'تدريب 200 قيادي حكومي على مهارات القيادة.', 'en' => 'Training 200 government leaders on leadership skills.'], 'slug' => ['ar' => 'leadership-program', 'en' => 'leadership-program'], 'client' => 'Ministry of Planning', 'field' => 'Training', 'year' => 2024, 'is_featured' => true],
        ];

        $experts = Expert::all();

        foreach ($projects as $data) {
            $project = Project::create($data);
            $project->experts()->attach($experts->random(min(2, $experts->count()))->pluck('id'));
        }
    }

    public function seedTrainingBags(): void
    {
        $defaultFiles = [
            ['ar' => 'شرائح العرض PowerPoint', 'en' => 'PowerPoint Slides'],
            ['ar' => 'دليل المدرب Word', 'en' => 'Trainer Guide (Word)'],
            ['ar' => 'مذكرة المتدرب Word', 'en' => 'Trainee Workbook (Word)'],
            ['ar' => 'أوراق العمل والتمارين', 'en' => 'Worksheets & Exercises'],
            ['ar' => 'الاختبار القبلي والبعدي', 'en' => 'Pre/Post Assessment'],
            ['ar' => 'الدليل التعريفي للحقيبة', 'en' => 'Bag Overview Guide'],
            ['ar' => 'نموذج تقييم الدورة', 'en' => 'Course Evaluation Form'],
        ];

        $bags = [
            [
                'title' => ['ar' => 'دورة تدريب المدربين TOT', 'en' => 'Train-the-Trainer (TOT) Program'],
                'description' => ['ar' => 'حقيبة تدريبية متكاملة لإكساب المشاركين مهارات التدريب الاحترافي.', 'en' => 'A complete training bag for professional trainer skills.'],
                'slug' => ['ar' => 'tot-training', 'en' => 'tot-training'],
                'field' => 'training',
                'duration_days' => 12,
                'duration_hours' => 60,
                'type' => 'ready',
                'slides_count' => 180,
                'general_objective' => [
                    'ar' => 'إكساب المشارك المعارف والمهارات الأساسية التي تمكنه من القيام بعملية التدريب وتقديم برامجه بمهنية واحترافية عالية.',
                    'en' => 'Equip participants with core knowledge and skills to deliver training programs professionally.',
                ],
                'detailed_objectives' => [
                    'ar' => "الإلمام بالعملية التدريبية\nاكتساب مهارات العرض والإلقاء\nإدارة حلقات الحوار وورش العمل\nتوظيف الأساليب التدريبية بكفاءة\nتصميم حقيبة تدريبية متكاملة\nالنجاح في تحديد وتحليل الاحتياجات التدريبية",
                    'en' => "Understand the training process\nDevelop presentation skills\nFacilitate workshops effectively\nApply training methods efficiently\nDesign integrated training bags\nAnalyze training needs successfully",
                ],
                'target_audience' => [
                    'ar' => "الراغبون في العمل كمدربين محترفين\nالمدربون والمعلمون الراغبون في صقل مهاراتهم\nالمسؤولون عن تطوير الموارد البشرية\nمديرو إدارات التدريب",
                    'en' => "Aspiring professional trainers\nTrainers and teachers seeking skill development\nHR development officers\nTraining department managers",
                ],
                'contents' => [
                    'ar' => '<h3>اليوم التدريبي الأول</h3><p><strong>الجلسة الأولى:</strong> التدريب مفهومه والتخطيط له</p><ul><li>مفهوم التعليم والتعلم والتدريب</li><li>خصائص التدريب وأهدافه</li><li>أساليب التعليم الحديثة</li></ul><h3>اليوم التدريبي الثاني</h3><p><strong>الجلسة الأولى:</strong> المدرب الاحترافي</p><ul><li>مواصفات ومهارات المدرب</li><li>تقنيات التدريب</li></ul>',
                    'en' => '<h3>Day 1</h3><p><strong>Session 1:</strong> Training concepts and planning</p><ul><li>Education, learning, and training concepts</li><li>Training characteristics and objectives</li></ul>',
                ],
                'included_files' => $defaultFiles,
            ],
            [
                'title' => ['ar' => 'الحوكمة الرشيدة', 'en' => 'Good Governance'],
                'description' => ['ar' => 'حقيبة تدريبية شاملة في مبادئ ومنهجيات الحوكمة الرشيدة.', 'en' => 'Comprehensive training bag on good governance principles.'],
                'slug' => ['ar' => 'good-governance', 'en' => 'good-governance'],
                'field' => 'governance', 'duration_days' => 5, 'duration_hours' => 30, 'type' => 'ready', 'slides_count' => 120,
                'included_files' => array_slice($defaultFiles, 0, 5),
            ],
            [
                'title' => ['ar' => 'المتابعة والتقييم', 'en' => 'Monitoring & Evaluation'],
                'description' => ['ar' => 'تعلم أساسيات M&E من التصميم إلى التقييم.', 'en' => 'Learn M&E fundamentals from design to evaluation.'],
                'slug' => ['ar' => 'monitoring-evaluation', 'en' => 'monitoring-evaluation'],
                'field' => 'm_e', 'duration_days' => 3, 'duration_hours' => 18, 'type' => 'ready', 'slides_count' => 80,
                'included_files' => array_slice($defaultFiles, 0, 5),
            ],
        ];

        foreach ($bags as $i => $data) {
            $preview = new TrainingBag($data);
            $contentSections = TrainingBagSections::migrateLegacyBag($preview);
            $metaHighlights = TrainingBagMeta::migrateLegacy($preview);

            $bag = TrainingBag::create([
                ...$data,
                'content_sections' => $contentSections,
                'meta_highlights' => $metaHighlights,
                'sort_order' => $i + 1,
            ]);

            TrainingBagSample::create([
                'training_bag_id' => $bag->id,
                'type' => 'video',
                'title' => ['ar' => 'مقدمة البرنامج', 'en' => 'Program Introduction'],
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_public' => true,
            ]);
        }
    }

    public function seedActivities(): void
    {
        TrainingActivity::create([
            'title' => ['ar' => 'نشاط العصف الذهني', 'en' => 'Brainstorming Activity'],
            'slug' => ['ar' => 'brainstorming-activity', 'en' => 'brainstorming-activity'],
            'excerpt' => ['ar' => 'نشاط جماعي لتحديد التحديات والحلول.', 'en' => 'Group activity to identify challenges and solutions.'],
            'content' => ['ar' => '<h3>خطوات النشاط</h3><ul><li>قسّم المشاركين إلى مجموعات</li><li>ناقش التحديات الرئيسية</li><li>اقترح حلول عملية</li><li>اعرض النتائج</li></ul>', 'en' => '<h3>Activity Steps</h3><ul><li>Divide participants into groups</li><li>Discuss key challenges</li><li>Propose practical solutions</li><li>Present results</li></ul>'],
            'sort_order' => 1,
        ]);
        TrainingActivity::create([
            'title' => ['ar' => 'دراسة حالة تفاعلية', 'en' => 'Interactive Case Study'],
            'slug' => ['ar' => 'case-study', 'en' => 'case-study'],
            'excerpt' => ['ar' => 'تحليل حالة واقعية وتطبيق المفاهيم.', 'en' => 'Analyze a real case and apply concepts.'],
            'content' => ['ar' => '<h3>الهدف</h3><p>تطبيق مفاهيم الحوكمة على حالة واقعية من خلال نقاش موجه.</p>', 'en' => '<h3>Objective</h3><p>Apply governance concepts to a real case through guided discussion.</p>'],
            'sort_order' => 2,
        ]);
    }

    public function seedVideos(): void
    {
        VideoItem::create([
            'title' => ['ar' => 'مقدمة عن مركز رايت', 'en' => 'Introduction to RIGHT Center'],
            'slug' => ['ar' => 'right-intro', 'en' => 'right-intro'],
            'description' => ['ar' => 'فيدio تعريفي بمركز رايت وخدماته.', 'en' => 'Introductory video about RIGHT Center and its services.'],
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'sort_order' => 1,
        ]);
        VideoItem::create([
            'title' => ['ar' => 'أساسيات الحوكمة الرشيدة', 'en' => 'Good Governance Fundamentals'],
            'slug' => ['ar' => 'governance-fundamentals', 'en' => 'governance-fundamentals'],
            'description' => ['ar' => 'محاضرة مصورة عن مبادئ الحوكمة.', 'en' => 'Video lecture on governance principles.'],
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'sort_order' => 2,
        ]);
    }

    public function seedPublications(): void
    {
        Publication::create([
            'title' => ['ar' => 'دليل الحوكمة للمؤسسات الأهلية', 'en' => 'NGO Governance Guide'],
            'slug' => ['ar' => 'ngo-governance-guide', 'en' => 'ngo-governance-guide'],
            'description' => ['ar' => 'دليل عملي لتطبيق مبادئ الحوكمة.', 'en' => 'Practical guide for governance implementation.'],
            'excerpt' => ['ar' => 'دليل شامل يوضح كيفية تطبيق مبادئ الحوكمة الرشيدة في المؤسسات الأهلية.', 'en' => 'Comprehensive guide on applying good governance in NGOs.'],
            'content' => ['ar' => '<h2>مقدمة</h2><p>يهدف هذا الدليل إلى مساعدة المؤسسات الأهلية على بناء أنظمة حوكمة فعالة.</p><h2>المبادئ الأساسية</h2><ul><li>الشفافية</li><li>المساءلة</li><li>المشاركة</li></ul>', 'en' => '<h2>Introduction</h2><p>This guide helps NGOs build effective governance systems.</p>'],
            'category' => 'governance', 'year' => 2024,
        ]);
        Publication::create([
            'title' => ['ar' => 'إطار M&E للمشاريع التنموية', 'en' => 'M&E Framework for Development Projects'],
            'slug' => ['ar' => 'me-framework', 'en' => 'me-framework'],
            'description' => ['ar' => 'إطار متكامل للمتابعة والتقييم.', 'en' => 'Integrated M&E framework.'],
            'excerpt' => ['ar' => 'إطار عملي للمتابعة والتقييم في المشاريع التنموية.', 'en' => 'Practical M&E framework for development projects.'],
            'content' => ['ar' => '<h2>نظرة عامة</h2><p>يقدم هذا الإطار منهجية متكاملة لتصميم وتطبيق أنظمة M&E.</p>', 'en' => '<h2>Overview</h2><p>This framework provides an integrated approach to M&E systems.</p>'],
            'category' => 'm_e', 'year' => 2023,
        ]);
    }
}
