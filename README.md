## Usage
`git nxt` gives you the following output: 

````
[nxt] List of current tags:
    0.0.0   0.0.1   0.0.2   0.0.3   0.0.4   0.0.5   0.0.6   0.0.7   0.1.0   0.1.1   0.1.2   0.1.3   0.1.4   0.1.5   0.1.6   0.1.7   0.1.8  
[nxt] Last tag seems like 0.1.8
[nxt] Next patch is 0.1.9
[nxt] Next minor is 0.2.0
[nxt] Next major is 1.0.0
````

other examples:

````
[nxt] Last tag seems like 1.0.0-rc.1
[nxt] Next release candidate is 1.0.0-rc.2
[nxt] Next major is 1.0.0
````
or with vTAG
````
[nxt] Last tag seems like v0.1.9
[nxt] Next patch is v0.1.10
[nxt] Next minor is v0.2.0
[nxt] Next major is v1.0.0
````

## Installation
As seen on https://gitbetter.substack.com/p/automate-repetitive-tasks-with-custom

* Clone the git repo (and copy the folder location)
* Add to  to bashrc or to zshrc
` export PATH=$PATH:/your-directory/git-nxt-repo-folder ` 
* restart terminal or source the file
`source ~/.zshrc`
* use the new command (in a git repo)
`git nxt`

## Todo
* improve by testing that we are in actual git folder
* improve semver sorting with https://github.com/z4kn4fein/php-semver 
* add suggestions for alpha releases and other types
* Add command for creating the tag
* Build binary in GH actions and allow single download of that

## Done
* Test for no tags (suggest 1.0.0)
* When in repo with numeric tags, it suggests the next major, minor or patch.

## Bonus
If you want something faster tghan typing out git nxt, you can always use this alias:
`alias gn=git nxt` 
It's in all your terminals if you also add it to ~/.zshrc
