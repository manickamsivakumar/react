import React, { createContext } from 'react';
//import { DateTime } from 'luxon';
import Urlobjmaker from '../Urlobjmaker';
import Apicallprocess from '../Apicallprocess';
//import axios from 'axios';
//import $ from "jquery";
//import Navbar from './Navbar';
//import Todolist from './Todolist';

export const PareasrvsettleContext = createContext();

class PareasrvsettleContextProvider extends React.Component {

    constructor(props) {
        super(props)
        //const now = DateTime.now();
        //console.log(now);
        this.state = {
            posvalues: {}
        }


    }



    componentDidMount() {
        // function calls one time when it is rendered for the first time
        // Good place for data loading
        //console.log('componentDidMount');
        //changeContext();
    }

    componentDidUpdate() {
        // function called when the state is updated or changd
        // Good place todo more data loading when state and props change
        //console.log('componentDidUpdate');

        //console.log("comp updated");


    }

    changeContext = async (data) => {
        //console.log(data);
        if (data) {
            // var urlobj = new Urlobjmaker(data, 'posareasrvsettlevalues');
            // console.log(urlobj);
            // console.log(urlobj.options())
            // var response = await axios(urlobj.options());
            //console.log(data);
            var urlobj = new Urlobjmaker(data, data.viewmode);
            //console.log(urlobj);
            var response = await Apicallprocess(urlobj.madeurl, urlobj.postdata);
            if (response) {
                this.setState({ posvalues: response })
            }
            //console.log(response);
        }
    }

    render() {

        return (
            <PareasrvsettleContext.Provider value={{ ...this.state, changecontext: this.changeContext }}>
                {this.props.children}
            </PareasrvsettleContext.Provider>
        );
    }
}

export default PareasrvsettleContextProvider;