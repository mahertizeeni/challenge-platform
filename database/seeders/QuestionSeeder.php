<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {

        $response = Http::get('https://opentdb.com/api.php?amount=20&category=21&difficulty=hard&type=multiple');

        $data = $response->json();

        if (!isset($data['results'])) {
            $this->command->error(' لم يتم العثور على نتائج من OpenTDB.');
            return;
        }
        foreach ($data['results'] as $item) {
            $originalQuestion = html_entity_decode($item['question']);
            $originalAnswer = html_entity_decode($item['correct_answer']);

            // ترجمة السؤال
            $translatedQuestion = $this->translate($originalQuestion);
            // ترجمة الجواب
            $translatedAnswer = $this->translate($originalAnswer);

            // لو فشلت الترجمة، نستخدم النص الأصلي بدل null
            $translatedQuestion = $translatedQuestion ?: $originalQuestion;
            $translatedAnswer = $translatedAnswer ?: $originalAnswer;

            // حفظ بالسجلات
             try{ Question::create([
                'question' => $translatedQuestion . " / " . $originalQuestion,
                'category_id' => 1,
                'answer' => $translatedAnswer . " / " . $originalAnswer,
            ]);}
             catch (\Exception $e) {
                $this->command->error("خطأ في حفظ السؤال: " . $e->getMessage());
                continue; // تخطي في حالة أي خطأ آخر

            }

        }

    }

    /**
     * دالة لترجمة النص من الإنجليزية إلى العربية باستخدام MyMemory API
     */
    private function translate(string $text): ?string
    {
        try {
            $response = Http::get('https://api.mymemory.translated.net/get', [
                'q' => $text,
                'langpair' => 'en|ar'
            ]);

            $json = $response->json();

            return $json['responseData']['translatedText'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
