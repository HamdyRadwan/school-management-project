<?php

namespace App\Livewire;

use App\Models\Question;
use App\Models\Quizze;
use Livewire\Component;
use App\Models\Degree;

class ShowQuestion extends Component
{

    public $quizze_id, $student_id, $data, $counter=0, $questioncount = 0;

    public function render()
    {
        $this->data = Question::where('quizze_id', $this->quizze_id)->get();
        $this->questioncount = $this->data->count();
        // dd($this->data);
        return view('livewire.show-question', ['data']);
    }


    public function nextQuestion($question_id, $score, $answer, $right_answer)
    {
        $stuDegree = Degree::where('student_id', $this->student_id)
            ->where('quizze_id', $this->quizze_id)
            ->first();
        // insert
        if ($stuDegree == null) {
            $degree = new Degree();
            $degree->quizze_id = $this->quizze_id;
            $degree->student_id = $this->student_id;
            $degree->question_id = $question_id;
            if (strcmp(trim($answer), trim($right_answer)) === 0) {
                $degree->score += $score;
            } else {
                $degree->score += 0;
            }
            $degree->date = date('Y-m-d');
            $degree->save();
        } else {

            // update           old (1)         new  (2)
// الطبيعى الرقم الجديد ال انا جاى بية يكون اكبر من القديم بمقدار واحد (ترتيب ال اى دى فى جدول الاسئلة)  وفيما عدا ذلك تلاعب
// عشان لما بعمل ريفريش للصفحة بيرجعنى لاول سؤال وبالتالى الرقم الجديد ال انا جاى بية(1) هيكون اقل من القديم (تلاعب)
// (ولو عامل ريفريش من تانى سؤال ف الرقم الجديد هيساوى القديم)
            if ($stuDegree->question_id >= $this->data[$this->counter]->id) {
            // if ($stuDegree->question_id >= $question_id) {
                $stuDegree->score = 0;
                $stuDegree->abuse = '1';
                $stuDegree->save();
                toastr()->error('تم إلغاء الاختبار لإكتشاف تلاعب بالنظام');
                return redirect('student_exams');
            } else {

                $stuDegree->question_id = $question_id;
                if (strcmp(trim($answer), trim($right_answer)) === 0) {
                    $stuDegree->score += $score;
                } else {
                    $stuDegree->score += 0;
                }
                $stuDegree->save();
            }
        }

        if ($this->counter < $this->questioncount - 1) {
            $this->counter++;
        } else {
            toastr()->success('تم إجراء الاختبار بنجاح');
            return redirect('student_exams');
        }

    }
}
