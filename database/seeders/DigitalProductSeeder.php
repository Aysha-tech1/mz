<?php

namespace Database\Seeders;

use App\Models\DigitalProduct;
use Illuminate\Database\Seeder;

class DigitalProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'step_number' => 1,
                'title' => 'كيف أبدأ؟',
                'label' => 'ملف اختيار المجال',
                'description' => 'ملف يساعدك على تقييم المجالات واختيار الأنسب لك قبل أن تستثمر.',
                'full_description' => "ملف يساعدك على تقييم المجالات واختيار الأنسب لك قبل أن تستثمر.\n\nستجد داخله خطوات عملية لاختيار مجال المتجر بناءً على اهتمامك، الطلب في السوق، وقدرتك على التنفيذ.",
                'is_free' => true,
                'price' => 0,
                'old_price' => null,
                'is_coming_soon' => false,
                'is_featured' => false,
            ],
            [
                'step_number' => 2,
                'title' => 'استيراد المنتجات',
                'label' => 'ملف الاستيراد',
                'description' => 'من اختيار المورد إلى استلام الشحنة وحساب التكلفة النهائية.',
                'full_description' => "من اختيار المورد إلى استلام الشحنة وحساب التكلفة النهائية.\n\nيغطي الملف اختيار المورد، حساب التكاليف، والشحن حتى تصل المنتجات بشكل واضح.",
                'is_free' => false,
                'price' => 3,
                'old_price' => null,
                'is_coming_soon' => false,
                'is_featured' => false,
            ],
            [
                'step_number' => 3,
                'title' => 'تسعير المنتجات',
                'label' => 'ملف التسعير',
                'description' => 'احسب تكلفتك بدقة وحدد سعر بيع يحقق لك الربح.',
                'full_description' => "احسب تكلفتك بدقة وحدد سعر بيع يحقق لك الربح.\n\nيساعدك الملف على بناء سعر عادل يغطي التكاليف ويترك هامش ربح مناسب.",
                'is_free' => false,
                'price' => 3,
                'old_price' => null,
                'is_coming_soon' => false,
                'is_featured' => false,
            ],
            [
                'step_number' => 4,
                'title' => 'إنشاء المتجر الإلكتروني',
                'label' => 'ملف إنشاء المتجر',
                'description' => 'خطوات تجهيز المتجر وإطلاقه بشكل صحيح.',
                'full_description' => "خطوات تجهيز المتجر وإطلاقه بشكل صحيح.\n\nمن إعداد الصفحات الأساسية إلى تجربة الشراء قبل الإطلاق.",
                'is_free' => false,
                'price' => 5,
                'old_price' => null,
                'is_coming_soon' => true,
                'is_featured' => false,
            ],
            [
                'step_number' => 5,
                'title' => 'ترخيص المتجر الإلكتروني',
                'label' => 'ملف ترخيص المتجر',
                'description' => 'متطلبات الترخيص وكيف تنظم أوراقك قبل التقديم.',
                'full_description' => "متطلبات الترخيص وكيف تنظم أوراقك قبل التقديم.\n\nملف يوضح المستندات والترتيب الصحيح قبل رفع طلب الترخيص.",
                'is_free' => true,
                'price' => 0,
                'old_price' => null,
                'is_coming_soon' => true,
                'is_featured' => false,
            ],
            [
                'step_number' => 6,
                'title' => 'تسجيل المتجر في منصة معروف',
                'label' => 'ملف تسجيل المتجر',
                'description' => 'خطوات التسجيل في المنصة وما تحتاجه قبل البدء.',
                'full_description' => "خطوات التسجيل في المنصة وما تحتاجه قبل البدء.\n\nيرشدك الملف لمتطلبات معروف وترتيب الحساب قبل الإطلاق.",
                'is_free' => true,
                'price' => 0,
                'old_price' => null,
                'is_coming_soon' => true,
                'is_featured' => false,
            ],
            [
                'step_number' => 7,
                'title' => 'تطوير مشروعي الحالي',
                'label' => 'ملف التطوير',
                'description' => 'راجع مشروعك الحالي وحدد ما يرفع مبيعاتك.',
                'full_description' => "راجع مشروعك الحالي وحدد ما يرفع مبيعاتك.\n\nيركز الملف على تحسين العرض، التسعير، وقنوات البيع للمتجر القائم.",
                'is_free' => false,
                'price' => 4,
                'old_price' => null,
                'is_coming_soon' => true,
                'is_featured' => false,
            ],
            [
                'step_number' => 8,
                'title' => 'كتيب التجارة الإلكترونية المتكامل',
                'label' => 'الكتيب المتكامل',
                'description' => 'كل الخطوات في كتيب واحد، من الفكرة إلى النمو.',
                'full_description' => "كل الخطوات في كتيب واحد، من الفكرة إلى النمو.\n\nيجمع الكتيب المسار كاملًا: الفكرة، الاستيراد، التسعير، المتجر، والترخيص.",
                'is_free' => false,
                'price' => 12,
                'old_price' => 15,
                'is_coming_soon' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            DigitalProduct::updateOrCreate(
                ['step_number' => $product['step_number']],
                array_merge($product, ['is_active' => true])
            );
        }
    }
}
