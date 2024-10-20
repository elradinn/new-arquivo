import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import DeleteUserForm from "@/Modules/Profile/Forms/DeleteUserForm";
import UpdatePasswordForm from "@/Modules/Profile/Forms/UpdatePasswordForm";
import UpdateProfileInformationForm from "@/Modules/Profile/Forms/UpdateProfileInformationForm";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/Modules/Common/Types";
import { Paper } from "@mantine/core";
import classes from "@/Modules/Profile/Styles/Edit.module.css";

export default function EditProfile({
    mustVerifyEmail,
    status,
}: PageProps<{ mustVerifyEmail: boolean; status?: string }>) {
    return (
        <Authenticated>
            <Head title="Profile" />

            <div className={classes.container}>
                <Paper shadow="xs" radius="md" className={classes.card}>
                    <UpdateProfileInformationForm
                        mustVerifyEmail={mustVerifyEmail}
                        status={status}
                    />
                </Paper>
                <Paper shadow="xs" radius="md" className={classes.card}>
                    <UpdatePasswordForm />
                </Paper>

                <Paper shadow="xs" radius="md" className={classes.card}>
                    <DeleteUserForm />
                </Paper>
            </div>
        </Authenticated>
    );
}
