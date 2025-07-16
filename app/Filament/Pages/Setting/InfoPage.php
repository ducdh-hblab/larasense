<?php

namespace App\Filament\Pages\Setting;

use App\Models\Site as SiteModel;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Locked;
use Filament\Facades\Filament;

use function Filament\authorize;

/**
 * @property Form $form
 */
class InfoPage extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'Site Info';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $slug = 'settings/site';

    protected ?string $heading = 'Site Info';

    protected ?string $subheading = 'Custom page title';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.settings.info';

    public ?array $data = [];

    #[Locked]
    public ?SiteModel $record = null;

    public function mount(): void
    {
        $this->record = SiteModel::firstOrCreate([
        ]);

        abort_unless(static::canView($this->record), 404);

        $this->fillForm();
    }

    public function fillForm(): void
    {
        $data = $this->record->attributesToArray();

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $data = $this->mutateFormDataBeforeSave($data);

            $this->handleRecordUpdate($this->record, $data);

        } catch (Halt $exception) {
            return;
        }

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl);
        }
    }

    public function makeFavicon()
    {
        // TODO
        $storagePath = '';
        $filename = '';
        $image = $this->record->image;

    }

    protected function getSavedNotification(): ?Notification
    {
        $title = $this->getSavedNotificationTitle();

        if (blank($title)) {
            return null;
        }

        return Notification::make()
            ->success()
            ->title($this->getSavedNotificationTitle());
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('filament-panels::pages/tenancy/edit-tenant-profile.notifications.saved.title');
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    public function form(Form $form): Form
    {
        $maxFileSize = convertToByte(ini_get('upload_max_filesize')) / 1024;

        return $form
            ->schema([
                Section::make('SEO Information')
                    ->description('Choose the template and edit the column names.')
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Site name')
                                    ->hint('Required')
                                    ->required(),
                                TextInput::make('title')
                                    ->hint('Required')
                                    ->required(),
                                FileUpload::make('site_logo')
                                    ->label(__('Site Logo'))
                                    ->hint('Recommend 200×200')
                                    ->helperText(__('This is the platform logo (e.g. Used in site favicon)'))
                                    ->image()
                                    ->disk('s3')
                                    ->directory('attachments')
                                    ->visibility('logo')
                                    ->columnSpan(1)
                                    ->maxSize($maxFileSize),
                                Textarea::make('desc')
                                    ->label(__('Description'))
                                    ->rows(3),
                                TagsInput::make('keywords')
                                    ->placeHolder('New keywords')
                                    ->separator(',')
                            ])->columns(1),
                        Group::make()
                            ->schema([
//                                ViewField::make('preview')
//                                    ->label('Preview')
//                                    ->view('filament.preview.info'),
                            ])->columnSpan(1),
                    ])->columns(2)
            ])
            ->model($this->record)
            ->statePath('data')
            ->operation('edit');
    }

    protected function handleRecordUpdate(SiteModel $record, array $data): SiteModel
    {
        $record->update($data);

        return $record;
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-panels::pages/tenancy/edit-tenant-profile.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    public static function canView(Model $record): bool
    {
        try {
            return authorize('update', $record)->allowed();
        } catch (AuthorizationException $exception) {
            return $exception->toResponse()->allowed();
        }
    }
}
