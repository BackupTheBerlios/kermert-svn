/*
# ***** BEGIN LICENSE BLOCK *****
# This file is part of Kermert.
# Copyright (c) 2005 Pierre-Yves Gillier and contributors. All rights
# reserved.
#
# Original contributor: Olivier Meunier
#
# Kermert is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# Kermert is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Kermert; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****
*/

function openClose(id,mode)
{
	if(document.getElementById) {
		element = document.getElementById(id);
	} else if(document.all) {
		element = document.all[id];
	} else return;

	if(element.style) {
		if(mode == 0) {
			if(element.style.display == 'block' ) {
				element.style.display = 'none';
			} else {
				element.style.display = 'block';
			}
		} else if(mode == 1) {
			element.style.display = 'block';
		} else if(mode == -1) {
			element.style.display = 'none';
		}
	}
}

function operations(action,mode)
{
	openClose('actionframe',mode);
	if(document.getElementById) {
		element = document.getElementById('actioncontent');
	} else if(document.all) {
		element = document.all['actioncontent'];
	} else return;
	element.src='./operations.php?op='+action;
	return;
}

function getElement(id)
{
	if(document.getElementById) {
		return document.getElementById(id);
	} else if(document.all) {
		return document.all[id];
	} else return;

}