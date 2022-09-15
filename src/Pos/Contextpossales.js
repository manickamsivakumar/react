import React from 'react'

//import Possalesview_1 from './Possalesview_1';

import Possalesview from './Possalesview';

import PareasrvsettleContexttProvider from './contexts/PareasrvsettleContext';

//https://pixabay.com/api/?key=27514090-6b5d7f78b9ff35063a286c567&q=yellow+flowers&image_type=photo
import { useLocation } from "react-router-dom";
const Contextpossales = () => {
    //console.log(props);
    const locationval = useLocation();

    var propid = locationval.state.propid;
    var cmpid = locationval.state.cmpid;
    var userdtls=locationval.state.userdtls;
  
    return (
        <div>
            <PareasrvsettleContexttProvider>
                <Possalesview propid={propid} userdtls={userdtls} cmpid={cmpid} />
            </PareasrvsettleContexttProvider>
        </div>
    );
}


export default Contextpossales;
