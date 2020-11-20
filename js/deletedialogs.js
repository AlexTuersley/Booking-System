function deleteuserdialog(deleteTitle,id)
{
  bootbox.confirm("Are you sure you wish to delete the User: '<i>" + deleteTitle + "</i>' ? If this user has bookings or has a schedule, they will not be deleted! You must first remove their schedule and any bookings.", function(result){if(result){window.location.href="?delete&uid=" + id + ""}});
}
function deletescheduledialog(deleteTitle,id)
{
  bootbox.confirm("Are you sure you wish to delete this Schedule: '<i>" + deleteTitle + "</i>' ? If there are bookings with this schedule time it may not be deleted.", function(result){if(result){window.location.href="?delete&sid=" + id + ""}});
}
function deletebookingdialog(deleteTitle,id)
{
  bootbox.confirm("Are you sure you wish to delete this Booking: '<i>" + deleteTitle + "</i>' ? If you wish to change the booking simple click the edit button instead.", function(result){if(result){window.location.href="?delete&bid=" + id + ""}});
}
function deletedepartmentdialog(deleteTitle,id)
{
  bootbox.confirm("Are you sure you wish to delete this Department: '<i>" + deleteTitle + "</i>' ? If this department has Users within, they must be moved to another department before deleting.", function(result){if(result){window.location.href="?remove=" + id + ""}});
}
function deleteuserdialog(deleteTitle,id)
{
  bootbox.confirm("Are you sure you wish to this Meeting Type: '<i>" + deleteTitle + "</i>' ? If this meeting type is in use all schedules associated must be removed before deleting.", function(result){if(result){window.location.href="?delete&mtid=" + id + ""}});
}