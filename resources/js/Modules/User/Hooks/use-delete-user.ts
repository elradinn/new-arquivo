import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { UserResourceData } from "../Types/UserResourceData";

interface IProps {
    user?: UserResourceData;
    close: () => void;
}

export function useDeleteUser({ user, close }: IProps) {
    const { delete: destroy, processing, reset } = useForm();

    const submit: React.FormEventHandler = (e) => {
        e.preventDefault();
        if (!user) return;

        destroy(route("user.destroy", user?.id), {
            onSuccess: () => {
                notifications.show({
                    message: "User deleted successfully",
                    color: "red",
                });
                close();
                reset();
            },
            onError: () => {
                notifications.show({
                    message: "Failed to delete user",
                    color: "red",
                });
            },
        });
    };

    return { submit, processing };
}