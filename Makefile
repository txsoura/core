pull:
	git pull origin develop

git:
	bash git-cli.sh

merge:
	git checkout master
	git pull origin master 
	git merge develop
	git push
