<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Support\TrainingFieldOptions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageTrainingFields extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'الإعدادات';

    protected static ?string $navigationLabel = 'مجالات التدريب';

    protected static ?string $title = 'مجالات التدريب';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.manage-training-fields';

    public ?array $data = [];

    public function mount(): void
    {
        $fields = TrainingFieldOptions::all();
        $items = [];

        foreach ($fields as $key => $label) {
            $items[] = ['key' => $key, 'label' => $label];
        }

        $this->form->fill(['fields' => $items]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('قائمة المجالات')
                    ->description('هذه القائمة تظهر في حقل "المجال" عند إضافة أو تعديل حقيبة تدريبية. المفتاح (key) يُستخدم داخلياً ولا يُفضّل تغييره بعد الاستخدام.')
                    ->schema([
                        Forms\Components\Repeater::make('fields')
                            ->label('المجالات')
                            ->schema([
                                Forms\Components\TextInput::make('key')
                                    ->label('المفتاح')
                                    ->required()
                                    ->alphaDash()
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('label')
                                    ->label('الاسم بالعربية')
                                    ->required()
                                    ->maxLength(100),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('إضافة مجال')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $fields = [];

        foreach ($this->form->getState()['fields'] ?? [] as $item) {
            if (! empty($item['key']) && ! empty($item['label'])) {
                $fields[$item['key']] = $item['label'];
            }
        }

        Setting::set('training_fields', $fields);

        Notification::make()
            ->title('تم حفظ مجالات التدريب')
            ->success()
            ->send();
    }
}
