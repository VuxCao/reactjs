/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */



require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/App');

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter ,Route, Routes } from 'react-router-dom';
import 'antd/dist/antd.css';
import Header from './Header';
import Add from "./Add";
import PostList from './List';

class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <div>
                    <Header />

                    <Routes>
                    <Route path='/create' element={<Add history={history} />} />
                
                    <Route path='/hello' element={<PostList/>}  />

                    </Routes>
                </div>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('app'));
