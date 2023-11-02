<!DOCTYPE html>
<html>
<head>
    <title>Passwortkarte Generator</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 0 auto;
        }
        table, th, td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 5px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-size: 14px;
        }
        th:first-child {
            background-color: #4CAF50;
        }
        td:first-child {
            background-color: #4CAF50;
            color: white;
        }
        input[type="number"], input[type="text"] {
            padding: 5px;
            margin-right: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Passwortkarte Generator</h1>
    <form>
        <label for="rowCount">Anzahl Zeilen:</label>
        <input type="number" id="rowCount" min="1" max="26" value="10">
        <label for="webshop">Webshop:</label>
        <input type="text" id="webshop" placeholder="Webshop-Name">
        <label for "startCoordinate">Startkoordinate:</label>
        <input type="text" id="startCoordinate" placeholder="Beispiel: J7">
        <button type="button" onclick="generatePasswordCard()">Generieren</button>
    </form>

    <div id="passwordCard"></div>
    <div id="result"></div>

    <!-- Hinzugefügte Download-Taste -->
    <a id="downloadLink" style="display: none;">
        <button type="button" onclick="downloadPasswordCard()">Download</button>
    </a>

    <script>
        function generatePasswordCard() {
            const rowCount = parseInt(document.getElementById("rowCount").value);
            const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+{}[]|;:'\"<>,.?/~";

            let passwordCard = "<table>";

            // Zeile mit Buchstaben A-Z oben
            passwordCard += "<tr>";
            passwordCard += "<th></th>";
            for (let j = 0; j < rowCount; j++) {
                passwordCard += `<th>${alphabet.charAt(j)}</th>`;
            }
            passwordCard += "</tr>";

            for (let i = 1; i <= rowCount; i++) {
                passwordCard += "<tr>";
                // Grün gefärbte Nummerierung links
                passwordCard += `<td style="background-color: #4CAF50; color: white;">${i}</td>`;

                for (let j = 0; j < rowCount; j++) {
                    const randomChar = getRandomChar(characters);
                    passwordCard += `<td>${randomChar}</td>`;
                }

                passwordCard += "</tr>";
            }

            passwordCard += "</table>";

            const webshopName = document.getElementById("webshop").value;
            const startCoordinate = document.getElementById("startCoordinate").value;
            const password = generatePassword(startCoordinate, passwordCard);
            const result = `${startCoordinate} - ${webshopName} : ${password}`;

            document.getElementById("passwordCard").innerHTML = passwordCard;
            document.getElementById("result").innerText = result;

            // Zeige die Download-Taste an
            document.getElementById("downloadLink").style.display = "block";
        }

        function getRandomChar(characters) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            return characters.charAt(randomIndex);
        }

        function generatePassword(startCoordinate, passwordCard) {
            let password = "";
            const rows = passwordCard.split("<tr>");

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                if (row.includes(startCoordinate)) {
                    const cells = row.split("<td>");
                    for (let j = 1; j < cells.length; j++) {
                        password += cells[j].charAt(0);
                    }
                }
            }

            return password;
        }

        function downloadPasswordCard() {
            const passwordCardElement = document.getElementById("passwordCard");

            html2canvas(passwordCardElement).then(function(canvas) {
                const imgData = canvas.toDataURL("image/png");
                const link = document.createElement('a');
                link.href = imgData;
                link.download = 'password_card.png';
                link.click();
            });
        }
    </script>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</body>
</html>
