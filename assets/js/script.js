import DataTable from 'datatables.net-dt';

//let table = new DataTable('#myTable', {
    // config options...
//});

function searchCar(){
    const input = document.querySelector('.filter');
    console.log(input.value);

}

const items = document.querySelectorAll('.card-kilometers');

const filteredPrices = event =>
{
    event.preventDefault();

    const searchMin = Number(document.getElementById('lower').value);
    const searchMax = Number(document.getElementById('upper').value);

    items.forEach(item =>
    {
        const price = Number(item.querySelector('p').textContent);

        if (price < searchMin || price > searchMax)
            item.style.display = 'none';
        else
            item.style.display = 'block';
    });
};

const resetForm = () =>
{
    items.forEach(li => li.style.display = 'block');
};