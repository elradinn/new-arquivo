import React, { FormEventHandler, useEffect } from "react";
import { Button, Flex, Modal, Stack, Text, TextInput } from "@mantine/core";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { User } from "@/types";

interface IProps {
    isOpened: boolean;
    close: () => void;
    user?: User;
}

type FormData = Pick<User, "name" | "email">;

const EditUserForm: React.FC<IProps> = ({ isOpened, close, user }) => {
    const { data, setData, patch, processing, errors, reset } = useForm<FormData>({
        name: "",
        email: "",
    });

    useEffect(() => {
        if (user) {
            setData({
                name: user.name,
                email: user.email,
            });
        }
    }, [user]);

    const editUserSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        patch(route("user.update", user?.id), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "User edited successfully",
                    color: "green",
                });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={<Text size="lg">Edit User</Text>}
            size={550}
        >
            <form onSubmit={editUserSubmit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        label="Name"
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />

                    <TextInput
                        id="email"
                        type="text"
                        name="email"
                        value={data.email}
                        label="Description"
                        onChange={(e) => setData("email", e.target.value)}
                        error={errors.email}
                    />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Save
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default EditUserForm;
