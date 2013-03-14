<?php

interface IDataPresenter {
    public function to_json(array $items);
}

class DataPresenter implements IDataPresenter {
    public function to_json(array $items) {
        $output = array();
        foreach ($items as $item) {
            $output[] = array(
                'title' => (string) $item->title,
                'description' => (string) $item->description,
            );
        }
        return json_encode($output);
    }
}