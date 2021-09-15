#!/bin/csh

echo $1
cd ./Tex
/usr/local/bin/pdflatex -interaction nonstopmode $1
#mv *.pdf /var/tmp
