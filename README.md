# 480-hospital-database

- Login: You have three types of users: one admin, nurses, patients. In the login page users should
enter their username/password and select their type (admin, nurse, patient)
- Different users will have different functionalities:
o Admin:
1. Register a nurse: nurses cannot self-register. The admin should register them. In
addition to the information above, every nurse is assigned a username and a
passoword.
2. Update nurse info: any update in nurse info (other than phone# and address)
should be carried out by the admin.
3. Delete a nurse: remove a nurse from database.
4. Add Vaccine: upon receiving new doses of a vaccine, the admin updates the
repository.
5. Update Vaccine: in any case some vaccine (not on-hold) are removed from the
repository, admin updates the number of vaccines.
6. View Nurse info: view the information of a nurse and the times they have
scheduled for.
7. View Patient info: view the information of a patient, the times they have
scheduled for vaccination, and their vaccination history.
o Nurse:
8. Update information: Nurses can update their address and phone#
9. Schedule time: nurses can schedule for time slots that have less than 12 nurses
scheduled for them.
10. Cancel a time: nurses should be able to delete a time they have scheduled for.
11. View Information: Nurses can view their information, including the times they
have scheduled for.
12. Vaccination: upon delivering a vaccine, nurses should record the vaccination
o Patient:
13. Register: Patients can register their information. In addition to what described
above, a patient needs to pick a username and a password.
14. Update Info: patients can update their information.
15. Schedule a vaccination time: Patients should see the available time slot and be
able to select one as their schedule.
16. Cancel Schedule: Patients can delete their scheduled time (which will also
release one on-hold vaccine).
17. View information: Patients can see their information, the times they have
scheduled for vaccination, and their vaccination history