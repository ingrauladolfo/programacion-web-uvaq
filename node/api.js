var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var mongojs = require('mongojs');
var db = mongojs('customers', ['customers']);
var formurlencoded = require('form-urlencoded');

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));
//Find all customers

app.get('/public', function(req, res) {

    console.log('Fetching Customers...');

    db.customers.find(function(err, docs) {
        if (err) {

            res.send(err);

        } else {

            console.log('Sending Customers...');

            res.json(docs);

        }

    });

});


//Find a specific customer

app.get('/customers/:id/*', function(req, res) {
    console.log('Fetching Customer...');
    db.customers.findOne({ _id: mongojs.ObjectId(req.params.id) }, function(err, doc) {
        if (err) {
            res.send(err);
        } else {
            console.log('Sending Customer...');
            res.json(doc);
        }
    });
});

//Insert a new customer

app.post('/customers', function(req, res) {
    db.customers.insert(req.body, function(err, doc) {
        if (err) {
            res.send(err);
        } else {
            console.log('Adding Customer...');
            res.json(doc);
        }
    });
});

//update a customer data

app.put('/customers/:id', function(req, res) {
    db.customers.findAndModify({
        query: { _id: mongojs.ObjectId(req.params.id) },
        update: {
            $set: {
                name: req.body.fname,
                lname: req.body.lname,
            }
        },
        upsert: true,
        new: true
    }, function(err, doc) {
        if (err) {
            res.send(err);
        } else {
            console.log('Updating Customer...');
            res.json(doc);
        }
    });
});

//Delete a customer

app.delete('/customers/:id', function(req, res) {
    console.log('Fetching Product...');
    db.customers.remove({ _id: mongojs.ObjectId(req.params.id) }, function(err, doc) {
        if (err) {
            res.send(err);
        } else {
            console.log('Removing Customer...');
            res.json(doc);
        }
    });
});


//running the api.js

app.listen(3000, function() {
    console.log('Example app listening on port 3000!');
});