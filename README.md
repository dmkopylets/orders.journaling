# outfits.journaling
**This is my first experience learning Laravel on my own.**
Livewire technology, which I am interested in, is involved.
Now without the need for js programming, you can create
dynamic data entry forms in PHP

The launched program contains a menu at the bottom for correcting reference data

outfits are created "from scratch" or generated based on an existing one
Each outfit can be exported in pdf format

********

![demo-113838.png](Addons%2Fdemo-113838.png)
********

for run:

copy file .env.example to .env

docker-compose build

docker-compose up -d


( may need to be performed:

docker-compose exec web bash

composer update
)

********

for the correct display of the Cyrillic font in the pdf file, unpack the contents
of the Addons\cyrrilicFonts.zip file into the vendor/dompdf/dompdf/lib/fonts/ folder
