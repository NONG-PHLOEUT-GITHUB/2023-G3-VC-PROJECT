<?php

namespace App\Imports;

use App\Models\Exam;
use App\Models\Score;
use App\Models\Subject;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoreImport implements ToModel, WithHeadingRow
{
    protected $fileName;

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ','
        ];
    }

    public function headingRow(): int
    {
        return 2; // assuming the actual header is on the second row
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $userId = $this->getUserIdByName($row['first_name'], $row['last_name']);
        $examId = $this->getExamIdByName('M2');
        // dd($examId);

        $scores = [];

        $subjects = [
            'Khmer Literature',
            'Math',
            // 'Biology',
            // 'Earth Science',
            // 'Civics & Economics',
            // 'Physics',
            // 'Chemistry',
            // 'ICT',
            // 'Physical Education',
            // 'History',
            // 'Geography'
        ];
        // Iterate over each subject and create a Score object
        foreach ($subjects as $subjectName) {
            $subjectId = $this->getSubjectIdByName($subjectName);
            $scoreValue = $row[strtolower(str_replace(' ', '_', $subjectName))];

            // Create and store the Score object
            $scores[] = new Score([
                'exam_id' => $examId,
                'user_id' => $userId,
                'subject_id' => $subjectId,
                'score' => $scoreValue,
            ]);
        }


        return $scores;
    }

    private function getSubjectIdByName($subjectName)
    {
        $subject = Subject::where('subject_name', $subjectName)->first();
        return $subject ? $subject->id : null;
    }

    private function getUserIdByName($firstName, $lastName)
    {
        $user = User::where('first_name', $firstName)->where('last_name', $lastName)->first();
        // dd($user);
        return $user ? $user->id : null;
    }

    private function getExamIdByName($examName)
    {
        $exam = Exam::where('exam_code', $examName)->first();
        return $exam ? $exam->id : null;
    }

    // private function parseDate($date)
    // {
    //     return \Carbon\Carbon::createFromFormat('m/d/y', $date)->format('Y-m-d');
    // }
}
