<script type="text/javascript">
function toggle_block(block, icon)
{
	if (document.getElementById)
	{
		if (document.getElementById(block).style.display == 'block')
		{
			document.getElementById(block).style.display = 'none';
			icon.src = 'images/plus.gif';
			save_collapsed(block, true);
		}
		else
		{
			document.getElementById(block).style.display = 'block';
			icon.src = 'images/minus.gif';
			save_collapsed(block, false);
		}
	}
	else if (document.all)
	{
		if (document.all[block].style.display == 'block')
		{
			document.all[block].style.display = 'none';
			icon.src = 'images/plus.gif';
			save_collapsed(block, true);
		}
		else
		{
			document.all[block].style.display = 'block';
			icon.src = 'images/minus.gif';
			save_collapsed(block, false);
		}
	}
}

function save_collapsed(objid, addcollapsed)
{
	var collapsed = get_cookie("forum_collapse");
	var tmp = "";

	if (collapsed != null)
	{
		collapsed = collapsed.split(",");

		for (i in collapsed)
		{
			if (collapsed[i] != objid && collapsed[i] != "")
			{
				tmp = tmp + collapsed[i];
				tmp = tmp + ",";
			}
		}
	}

	if (addcollapsed)
	{
		tmp = tmp + objid;
	}

	expires = new Date();
	expires.setTime(expires.getTime() + (1000 * 86400 * 365));
	set_cookie("forum_collapse", tmp, expires);
}

function set_cookie(name, value, expires)
{
	if (!expires)
	{
		expires = new Date();
	}
	document.cookie = name + "=" + escape(value) + "; expires=" + expires.toGMTString() +  "; path=/";
}

function get_cookie(name)
{
	cookie_name = name + "=";
	cookie_length = document.cookie.length;
	cookie_begin = 0;
	while (cookie_begin < cookie_length)
	{
		value_begin = cookie_begin + cookie_name.length;
		if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
		{
			var value_end = document.cookie.indexOf (";", value_begin);
			if (value_end == -1)
			{
				value_end = cookie_length;
			}
			return unescape(document.cookie.substring(value_begin, value_end));
		}
		cookie_begin = document.cookie.indexOf(" ", cookie_begin) + 1;
		if (cookie_begin == 0)
		{
			break;
		}
	}
	return null;
}


//-->
</script>