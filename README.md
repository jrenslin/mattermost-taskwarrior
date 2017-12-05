# Taskwarrior Integration for Mattermost

This script serves to integrate [taskwarrior](https://taskwarrior.org/)'s most basic set of commands with [Mattermost](https://about.mattermost.com/). Each channel is taken to correspond to a given project.

## Installation

0. Have taskwarrior, PHP and some server software (e.g. nginx, Apache) running on your server.
1. Put the files into some served directory: `git clone https://github.com/jrenslin/mattermost-taskwarrior.git`
2. In Mattermost, create a new slash command.
3. Insert the URL on which this script runs into the field *Request URL* and set _task_ as the *Command Trigger Word*.
4. Click on *Save*.
5. In the directory this script is in, create a file `settings.php`. You can copy the sample: `cp settings_sample.php settings.php`.
6. Copy the token to the array of allowed tokens.
7. Done.

## Usage

The usage is similar to taskwarrior's, though always specific to the channel you are currently posting in. Run `/task add <Your task>` to add a task, `/task` to list all tasks associated to the channel/project.

### Supported commands

So far, only displaying (`list`), adding (`add`), and completing (`done`) tasks for a given project/channel are supported.
