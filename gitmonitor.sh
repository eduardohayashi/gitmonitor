#!/bin/bash

if [ $# -eq 0 ]; then
	echo "usage: gitmonitor [option] [path to repository]"
	echo "       --changed    list modified files"
	echo "       --untracked  list untracked files"
	exit 0
fi

cd $2
if [ $1 -eq "changed" ]; then
git ls-files -m
elif [ $1 -eq "untracked" ]; then
git ls-files --others --exclude-standard
fi
