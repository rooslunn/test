<?php

/**
 * Main controller class
 *
 * @author Ruslan Kladko <rkladko@gmail.com>
 * @version 0.1
 * 
 */
class Controller {

    /**
     * @var IDataProvider instance of IDataprovider
     */
    private $_provider;

    /**
     * @var IDataStore instance of IDataStore
     */
    private $_store;

    /**
     * @var IDataPresenter instance of IDataPresenter
     */
    private $_presenter;

    /**
     * Creates instance of controller. Sets local vars.
     * 
     * @param IDataProvider  $provider  instance of news provider
     * @param IDataStore     $store     instance of DB where to save search results 
     * @param IDataPresenter $presenter instance of news converter for presenting to client (browser)
     */
    public function __construct(IDataProvider $provider, IDataStore $store, IDataPresenter $presenter) {
        $this->_provider = $provider;
        $this->_store = $store;
        $this->_presenter = $presenter;
    }

    /**
     * Searches for query in news
     * @param  string $query
     * @return string result in json-encoded string
     */
    public function search_news_for($query) {
        $raw = $this->_provider->search_for($query);
        $this->_store->save($raw);
        $json = $this->_presenter->to_json($raw);
        return $json;
    }
}