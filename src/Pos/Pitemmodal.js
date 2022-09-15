import * as React from 'react';

const style = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 400,
    bgcolor: 'background.paper',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4,
};
//<Button onClick={handleOpen}>Open modal</Button>
export default function Pitemmodal(props) {

    var isopen = props.modalopen;
    var isopenbool = isopen == 1 ? true : false;
    const [open, setOpen] = React.useState(isopenbool);
    const handleOpen = () => setOpen(true);
    const handleClose = () => {
        console.log('handleClose')
        props.modalopen = 0;
        setOpen(false)
    }

    return (
        <div>
            
        </div>
    );
}
