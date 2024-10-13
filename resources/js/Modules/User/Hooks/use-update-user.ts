import { useForm } from "@inertiajs/react";
import { UpdateUserData } from "../Types/UpdateUserData";
import { notifications } from "@mantine/notifications";
import { UserResourceData } from "../Types/UserResourceData";

interface IProps {
    user?: UserResourceData;
    close: () => void;
}

export function useUpdateUser({ user, close }: IProps) {
    const { data, setData, patch, processing, errors, reset } = useForm<UpdateUserData>({
        name: user?.name || "",
    });

    const submit: React.FormEventHandler = (e) => {
        e.preventDefault();
        if (!user) return;

        patch(route("user.update", user.id), {
            onSuccess: () => {
                notifications.show({
                    message: "User updated successfully",
                    color: "green",
                });
                close();
                reset();
            },
            onError: () => {
                notifications.show({
                    message: "Failed to update user",
                    color: "red",
                });
            },
        });
    };

    return { data, setData, submit, processing, errors };
}