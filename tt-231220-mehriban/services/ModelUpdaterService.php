<?php
// TodoUpdaterService.php
namespace app\services;

use app\models\Todo;

class TodoUpdaterService
{
    /**
     * Check if the todo model's version matches the current version in the database.
     * If the versions match, update the model and increment the version.
     *
     * @param Todo $model
     * @return bool Whether the update was successful or a conflict occurred.
     */
    public function checkAndUpdateTodo(Todo $model): bool
    {
        $currentVersion = $this->getCurrentVersion($model);

        if ($currentVersion === $model->version) {
            // Versions match, update the model and increment the version
            $model->version++;
            return $model->save();
        } else {
            // Versions don't match, conflict
            return false;
        }
    }

    /**
     * Get the current version of the todo model from the database.
     *
     * @param Todo $model
     * @return int|null
     */
    private function getCurrentVersion(Todo $model): ?int
    {
        return Todo::find()->select('version')->where(['id' => $model->id])->scalar();
    }
}
