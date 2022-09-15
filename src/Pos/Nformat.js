const Nformat = (price) => {
    price = Number(price);
    if (price) {
        return price.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    } else {
        return 0;
    }

}

export default Nformat;

