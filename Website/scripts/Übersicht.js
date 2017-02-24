
function start() {
    node = document.getElementById("tabelle1");
    node.parentNode.insertBefore(createTable(3, 7), node );
}

function createTable(row, col, id) {

    var myTable     = document.createElement("table");
    var mytablebody = document.createElement("tbody");

    for(var j = 0; j < row; j++) {
        mycurrent_row = document.createElement("tr");
        for(var i = 0; i < col; i++) {
            mycurrent_cell = document.createElement("td");
            currenttext = document.createTextNode("row"+j+", column"+i+", ");
            mycurrent_cell.appendChild(currenttext);
            mycurrent_row.appendChild(mycurrent_cell);
        }

        mytablebody.appendChild(mycurrent_row);
    }

    myTable.appendChild(mytablebody);
    myTable.setAttribute("ID", id);
    return myTable;
}