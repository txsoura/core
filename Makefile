pull:
	git pull origin master

git:
	bash git-cli.sh

merge:
	git checkout master
	git pull origin master
	git push
