<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Rawilk\FilamentPasswordInput\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Management';

    /**
     * Configure the resource form.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255)
                            ]),
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Select::make('role')
                                    ->required()
                                    ->relationship(
                                        'roles',
                                        'name',
                                        fn (Builder $query) => $query->where('name', '!=', Role::SUPER_ADMIN)
                                    ),
                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->unique(ignoreRecord: true),
                            ]),
                        Forms\Components\Grid::make()
                            ->schema([
                                Password::make('password')
                                    ->required(fn (User $user) => ! $user->id)
                                    ->password()
                                    ->confirmed()
                                    ->revealable()
                                    ->copyable()
                                    ->copyMessage('Password has been copied!')
                                    ->regeneratePassword()
                                    ->maxLength(12)
                                    ->hidePasswordManagerIcons()
                                    ->hidden(fn (User $user) => (bool) $user->id),
                                Password::make('password_confirmation')
                                    ->required(fn (User $user) => ! $user->id)
                                    ->password()
                                    ->revealable()
                                    ->hidePasswordManagerIcons()
                                    ->hidden(fn (User $user) => (bool) $user->id),
                            ])
                    ])
            ]);
    }

    /**
     * Configure the resource table.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // Get all users that don't have the role Super Admin
                $notSuperAdmin = User::role(Role::SUPER_ADMIN)
                    ->pluck('id')
                    ->toArray();

                return $query->whereNotIn('id', $notSuperAdmin);
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->color(fn (User $user) => match ($user->hasRole(Role::ADMIN)) {
                        true => 'primary',
                        default => 'gray',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
