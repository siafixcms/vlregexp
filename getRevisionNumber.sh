#!/bin/sh
count=`git rev-list HEAD | wc -l | sed -e 's/ *//g' | xargs -n1`;
echo $count;
