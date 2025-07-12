<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Category;
use App\Models\DifficultyLevel;
use App\Models\User;


class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();

        $quizData = [
            [
                'title' => 'PHP Master Quiz',
                'category' => 'PHP',
                'level' => 'Beginner',
                'questions' => [
                    [
                        'text' => 'What does PHP stand for?',
                        'answers' => [
                            ['text' => 'Personal Home Page', 'is_correct' => true],
                            ['text' => 'Private Hypertext Processor', 'is_correct' => false],
                            ['text' => 'Public Hosting Protocol', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which symbol is used to declare a variable in PHP?',
                        'answers' => [
                            ['text' => '$', 'is_correct' => true],
                            ['text' => '#', 'is_correct' => false],
                            ['text' => '@', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which function outputs text in PHP?',
                        'answers' => [
                            ['text' => 'print()', 'is_correct' => true],
                            ['text' => 'display()', 'is_correct' => false],
                            ['text' => 'echoText()', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What is the default file extension for PHP files?',
                        'answers' => [
                            ['text' => '.php', 'is_correct' => true],
                            ['text' => '.html', 'is_correct' => false],
                            ['text' => '.txt', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which of the following is a PHP superglobal?',
                        'answers' => [
                            ['text' => '$_POST', 'is_correct' => true],
                            ['text' => '$post', 'is_correct' => false],
                            ['text' => 'POST$', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'JavaScript Core Concepts',
                'category' => 'JavaScript',
                'level' => 'Intermediate',
                'questions' => [
                    [
                        'text' => 'Which keyword is used to declare a constant in JS?',
                        'answers' => [
                            ['text' => 'const', 'is_correct' => true],
                            ['text' => 'let', 'is_correct' => false],
                            ['text' => 'var', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What is the result of "2" + 2 in JS?',
                        'answers' => [
                            ['text' => '22', 'is_correct' => true],
                            ['text' => '4', 'is_correct' => false],
                            ['text' => 'NaN', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'How do you write a comment in JS?',
                        'answers' => [
                            ['text' => '// comment', 'is_correct' => true],
                            ['text' => '# comment', 'is_correct' => false],
                            ['text' => '<!-- comment -->', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What is "typeof null"?',
                        'answers' => [
                            ['text' => 'object', 'is_correct' => true],
                            ['text' => 'null', 'is_correct' => false],
                            ['text' => 'undefined', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which array method removes the last element?',
                        'answers' => [
                            ['text' => 'pop()', 'is_correct' => true],
                            ['text' => 'shift()', 'is_correct' => false],
                            ['text' => 'slice()', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Laravel Basics',
                'category' => 'Laravel',
                'level' => 'Advanced',
                'questions' => [
                    [
                        'text' => 'Which command creates a controller in Laravel?',
                        'answers' => [
                            ['text' => 'php artisan make:controller', 'is_correct' => true],
                            ['text' => 'php artisan new:controller', 'is_correct' => false],
                            ['text' => 'laravel create controller', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What is Eloquent in Laravel?',
                        'answers' => [
                            ['text' => 'ORM for DB interaction', 'is_correct' => true],
                            ['text' => 'Routing system', 'is_correct' => false],
                            ['text' => 'Validation engine', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What file contains route definitions?',
                        'answers' => [
                            ['text' => 'web.php', 'is_correct' => true],
                            ['text' => 'routes.php', 'is_correct' => false],
                            ['text' => 'index.php', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which blade syntax outputs data?',
                        'answers' => [
                            ['text' => '{{ }}', 'is_correct' => true],
                            ['text' => '<?= ?>', 'is_correct' => false],
                            ['text' => '@{{ }}', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'How do you create a migration?',
                        'answers' => [
                            ['text' => 'php artisan make:migration', 'is_correct' => true],
                            ['text' => 'php artisan migrate:new', 'is_correct' => false],
                            ['text' => 'laravel create:migration', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'React Fundamentals',
                'category' => 'React',
                'level' => 'Beginner',
                'questions' => [
                    [
                        'text' => 'What is JSX?',
                        'answers' => [
                            ['text' => 'JavaScript XML', 'is_correct' => true],
                            ['text' => 'Java X Syntax', 'is_correct' => false],
                            ['text' => 'JSX Format', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which hook is used for state?',
                        'answers' => [
                            ['text' => 'useState', 'is_correct' => true],
                            ['text' => 'useEffect', 'is_correct' => false],
                            ['text' => 'useContext', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'What is a React component?',
                        'answers' => [
                            ['text' => 'Reusable UI block', 'is_correct' => true],
                            ['text' => 'CSS class', 'is_correct' => false],
                            ['text' => 'HTML tag', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which method renders JSX?',
                        'answers' => [
                            ['text' => 'return()', 'is_correct' => true],
                            ['text' => 'show()', 'is_correct' => false],
                            ['text' => 'renderHTML()', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'How do you handle events in React?',
                        'answers' => [
                            ['text' => 'camelCase props', 'is_correct' => true],
                            ['text' => 'snake_case props', 'is_correct' => false],
                            ['text' => 'onclick()', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'MySQL Deep Dive',
                'category' => 'MySQL',
                'level' => 'Advanced',
                'questions' => [
                    [
                        'text' => 'Which command shows all databases?',
                        'answers' => [
                            ['text' => 'SHOW DATABASES;', 'is_correct' => true],
                            ['text' => 'LIST DATABASES;', 'is_correct' => false],
                            ['text' => 'GET DBS;', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which is a valid data type in MySQL?',
                        'answers' => [
                            ['text' => 'VARCHAR', 'is_correct' => true],
                            ['text' => 'STRING', 'is_correct' => false],
                            ['text' => 'CHARACTER', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which clause filters results?',
                        'answers' => [
                            ['text' => 'WHERE', 'is_correct' => true],
                            ['text' => 'WHEN', 'is_correct' => false],
                            ['text' => 'IF', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'Which function returns current date?',
                        'answers' => [
                            ['text' => 'NOW()', 'is_correct' => true],
                            ['text' => 'CURRENT()', 'is_correct' => false],
                            ['text' => 'GETDATE()', 'is_correct' => false],
                        ]
                    ],
                    [
                        'text' => 'How do you remove a table?',
                        'answers' => [
                            ['text' => 'DROP TABLE table_name;', 'is_correct' => true],
                            ['text' => 'DELETE TABLE table_name;', 'is_correct' => false],
                            ['text' => 'REMOVE table_name;', 'is_correct' => false],
                        ]
                    ],
                ]
            ]
        ];

        foreach ($quizData as $quizInfo) {
            $category = Category::where('name', $quizInfo['category'])->first();
            $level = DifficultyLevel::where('name', $quizInfo['level'])->first();

            $quiz = Quiz::create([
                'title' => $quizInfo['title'],
                'category_id' => $category->id,
                'difficulty_level_id' => $level->id,
                'time_limit_minutes' => 10,
                'created_by' => $admin->id,
            ]);

            foreach ($quizInfo['questions'] as $q) {
                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $q['text'],
                ]);

                foreach ($q['answers'] as $a) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $a['text'],
                        'is_correct' => $a['is_correct'],
                    ]);
                }
            }
        }
    }
}
