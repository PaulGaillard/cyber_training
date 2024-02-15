const express = require('express');
const {exec} = require('child_process');
const app = express();
const port = 3000;
const pug = require('pug');

// Listen in on root
app.get('/', (req, res) => {
  const filename = req.query.filename;
  const fs = require('fs');
  // Le chemin du répertoire 
  const dir = '.';
  let files = [];
  // Utiliser fs.readdir pour obtenir la liste des éléments du répertoire 
  fs.readdir(dir,  {}, (err, files) => {
    if (err) {
      console.log(err);
      return;
    } 

    if (filename) {
      // On execute la commande avec le paramètre utilisateur
      exec(`Type  ${filename}`, (error, stdout, stderr) => {
        let output = stdout;
        if (error) {
          output = error; 
        }
        res.send(
          pug.renderFile('./pages/index.pug', {output: output, filename: filename, files: files})
        );
      });
    } else {
      res.send(pug.renderFile('./pages/index.pug', {files: files}));
    }
  });
});

app.listen(port, () => {
  console.log(`Example app listening at http://localhost:${port}`);
});