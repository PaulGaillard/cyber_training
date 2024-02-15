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
      const fs = require('fs'); 
      const path = require('path');

      const filePath = path.join(__dirname, filename); 
      // on vérifie que le fichier recherché est dans le dossier courant.
      if (filePath.startsWith(__dirname)){
        // on vérifie que le fichier existe
        fs.access(filePath, fs.constants.F_OK, (err) => { 
          if (err) { 
            res.send( pug.renderFile('./pages/index.pug', {output: `Le fichier n'existe pas`, filename: filename, files: files}) );
          } else {
            // on utilise une fonction native NodeJS pour lire le fichier
            fs.readFile(filePath, 'utf8', function (err, data) {
              if (err) {
                res.send( pug.renderFile('./pages/index.pug', {output: err.message, filename: filename, files: files}) );
              } else {
                res.send( pug.renderFile('./pages/index.pug', {output: data, filename: filename, files: files}) ); 
                }
            });
          }
        });
      } else {
        res.send( pug.renderFile('./pages/index.pug', {output: `Oh ! c'est interdit ici !`, filename: filename, files: files}) );
      }
    } else {
      res.send(pug.renderFile('./pages/index.pug', {files: files}));
    }
  });
});

app.listen(port, () => {
  console.log(`Example app listening at http://localhost:${port}`);
});