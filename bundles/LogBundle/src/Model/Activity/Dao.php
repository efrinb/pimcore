<?php

namespace LogBundle\Model\Activity;

use Doctrine\DBAL\Exception;
use Pimcore\Model\Dao\AbstractDao;
use Pimcore\Model\Exception\NotFoundException;

class Dao extends AbstractDao
{
    protected string $tableName = 'activities';

    public function getById(?int $id = null): void
    {
        if ($id !== null)  {
            $this->model->setId($id);
        }

        $data = $this->db->fetchAssociative('SELECT * FROM '.$this->tableName.' WHERE id = ?', [$this->model->getId()]);

        if(!$data) {
            throw new NotFoundException("Object with the ID " . $this->model->getId() . " doesn't exists");
        }

        $this->assignVariablesToModel($data);
    }

    /**
     * Save or update an Activity
     * @throws Exception
     */
    public function save(): void
    {
        $vars = get_object_vars($this->model);

        $buffer = [];

        $validColumns = $this->getValidTableColumns($this->tableName);

        if (count($vars)) {
            foreach ($vars as $k => $v) {
                if (!in_array($k, $validColumns)) {
                    continue;
                }

                $getter = "get" . ucfirst($k);

                if (!is_callable([$this->model, $getter])) {
                    continue;
                }

                $value = $this->model->$getter();

                if ($value instanceof \DateTime) {
                    // Convert DateTime to a suitable format, e.g., 'Y-m-d H:i:s'
                    $value = $value->format('Y-m-d H:i:s');
                } elseif (is_bool($value)) {
                    $value = (int) $value;
                }

                $buffer[$k] = $value;
            }
        }

        if ($this->model->getId() !== null) {
            $this->db->update($this->tableName, $buffer, ["id" => $this->model->getId()]);
            return;
        }

        $this->db->insert($this->tableName, $buffer);
        $this->model->setId($this->db->lastInsertId());
    }

    /**
     * Delete an Activity
     */
    public function delete(): void
    {
        $this->db->delete($this->tableName, ["id" => $this->model->getId()]);
    }
}
