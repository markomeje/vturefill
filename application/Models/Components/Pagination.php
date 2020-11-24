<?php

namespace VTURefill\Models\Components;
use VTURefill\Core\Logger;
use VTURefill\Library\Database;


class Pagination {

	public $currentPage, $itemsPerPage, $totalCount;

	public function __construct(int $currentPage = 1, int $totalCount = 0, int $itemsPerPage = 0) {
		$this->currentPage = empty($currentPage) ? 1 : (int)$currentPage;
		$this->totalCount = empty($totalCount) ? 0 : (int)$totalCount;
        $this->itemsPerPage = empty($itemsPerPage) ? PAGINATION_DEFAULT_LIMIT : (int)$itemsPerPage;
	}

	public static function paginate(string $query, array $fields, int $pageNumber, int $extraOffset = 0) {
        try {
            $database = Database::connect();
            $database->prepare($query);
            empty($fields) ? $database->execute() : $database->execute($fields);
            $totalCount = ($database->rowCount() > 0) ? $database->rowCount() : (int)0;
            $extraOffset = (int)$extraOffset > $totalCount ? 0 : (int)$extraOffset;
            return new Pagination((int)$pageNumber, $totalCount - $extraOffset);
        } catch (\Exception $error) {
            Logger::log("GETTING PAGINATION DATA ERROR", $error->getMessage(), __FILE__, __LINE__);
            return false;
        }
    }

	public function getOffset() {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function totalPages() {
        return ceil($this->totalCount/$this->itemsPerPage);
    }

    public function previousPage() {
        return $this->currentPage - 1;
    }

    public function nextPage() {
        return $this->currentPage + 1;
    }

    public function hasPreviousPage() {
        return $this->previousPage() >= 1 ? true : false;
    }

    public function hasNextPage() {
        return $this->totalPages() >= $this->nextPage() ? true : false;
    }

}
