psalm --no-progress --no-cache > psalm.out
cat psalm.out | sed G | sed -E 's|(.*) - ([a-zA-Z0-9 _\./\-]+:[[:digit:]]+)|'"$(pwd)"'/\2\
\1|g' | perl -pi -0 -w -e 's/\n\n/\n/g'
rm psalm.out
